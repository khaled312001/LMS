<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\FileUploader;
use App\Models\Setting;

class OpenAiController extends Controller
{
    function settings()
    {
        return view('admin.open_ai.settings');
    }

    function settings_update(Request $request)
    {
        $validated = $request->validate([
            'open_ai_model' => 'in:gpt-3.5-turbo,gpt-3.5-turbo-0125,gpt-4o-mini,gpt-4o,gpt-4-turbo',
            'open_ai_max_token' => 'required|numeric|min:0',
            'open_ai_secret_key' => 'required|max:255',
        ]);

        foreach ($request->all() as $type => $value) {
            if (Setting::where('type', $type)->count() == 0) {
                Setting::where('type', $type)->insert(['type' => $type, 'description' => $value]);
            } else {
                Setting::where('type', $type)->update(['description' => $value]);
            }
        }

        return redirect(route('admin.open.ai.settings'))->with('success', get_phrase('Open ai settings changed successfully'));
    }

    function generate(Request $request)
    {
        if ($request->service_type == 'Course thumbnail') {
            $prompt = "We have run a online LMS system. Please generate course thumbnails for me. \n Course topic: " . $request->ai_keywords;
            return $this->curl_call_to_generate_image_openai($prompt);
        } else {
            $prompt = "Write me a ";
            $prompt .= $request->service_type;
            $prompt .= " on ";
            $prompt .= $request->ai_keywords;
            $prompt .= " in ";
            $prompt .= $request->language;
            $prompt .= " language";

            $instructions = "You are a " . $request->service_type . " writer.";
            return $this->curl_call_to_generate_text_by_openai($prompt, $instructions);
        }
    }

    function curl_call_to_generate_image_openai($prompt)
    {
        $open_ai_secret_key = get_settings('open_ai_secret_key');

        $curlopt_post = ['prompt' => $prompt, 'model' => 'dall-e-3', 'size' => '1024x1024', 'n' => 1];
        $curlopt_post_url = 'https://api.openai.com/v1/images/generations';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $curlopt_post_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $open_ai_secret_key,
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($curlopt_post));

        $response = curl_exec($ch);

        curl_close($ch);

        $response_arr = json_decode($response, true);
        if (array_key_exists('error', $response_arr)) {
            $error_code = $response_arr['error']['code'] ?? '';
            $error_message = $response_arr['error']['message'] ?? '';
            
            // Handle insufficient quota error with helpful message
            if ($error_code == 'insufficient_quota' || strpos($error_message, 'quota') !== false || strpos($error_message, 'billing') !== false) {
                $helpful_message = [
                    'error' => [
                        'message' => 'Your OpenAI API quota has been exceeded. Please check your billing and add credits to your account at https://platform.openai.com/account/billing',
                        'type' => 'insufficient_quota',
                        'code' => 'insufficient_quota',
                        'help' => 'To resolve this: 1) Go to https://platform.openai.com/account/billing 2) Add payment method or top up credits 3) Wait a few minutes for the quota to update'
                    ]
                ];
                return json_encode($helpful_message);
            }
            
            return 'Error: ' . $error_message;
        } else {
            return json_encode($response_arr['data']);
        }
    }

    function curl_call_to_generate_text_by_openai($instructions, $prompt)
    {
        $open_ai_secret_key = get_settings('open_ai_secret_key');
        $open_ai_model = get_settings('open_ai_model');
        
        // Default to gpt-3.5-turbo if no model is set (most compatible)
        if (!$open_ai_model) {
            $open_ai_model = 'gpt-3.5-turbo';
        }
        
        // Auto-migrate deprecated model names
        if ($open_ai_model == 'gpt-4-0125-preview') {
            $open_ai_model = 'gpt-3.5-turbo';
            // Update database with new model name
            Setting::where('type', 'open_ai_model')->update(['description' => $open_ai_model]);
        }
        
        // Define fallback models in order of preference
        $fallback_models = ['gpt-3.5-turbo', 'gpt-3.5-turbo-0125', 'gpt-4o-mini'];
        
        $endpoint = "https://api.openai.com/v1/chat/completions";

        $data = array(
            "model" => $open_ai_model,
            "messages" => array(
                array(
                    "role" => "system",
                    "content" => $instructions
                ),
                array(
                    "role" => "user",
                    "content" => "$prompt"
                )
            )
        );

        $ch = curl_init($endpoint);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer " . $open_ai_secret_key
        ));

        $response = curl_exec($ch);
        curl_close($ch);


        if ($response) {
            $response = json_decode($response, true);
            if(isset($response['error'])){
                $error_code = $response['error']['code'] ?? '';
                $error_message = $response['error']['message'] ?? '';
                
                // Handle insufficient quota error with helpful message
                if ($error_code == 'insufficient_quota' || strpos($error_message, 'quota') !== false || strpos($error_message, 'billing') !== false) {
                    $helpful_message = [
                        'error' => [
                            'message' => 'Your OpenAI API quota has been exceeded. Please check your billing and add credits to your account at https://platform.openai.com/account/billing',
                            'type' => 'insufficient_quota',
                            'code' => 'insufficient_quota',
                            'help' => 'To resolve this: 1) Go to https://platform.openai.com/account/billing 2) Add payment method or top up credits 3) Wait a few minutes for the quota to update'
                        ]
                    ];
                    return json_encode($helpful_message);
                }
                
                // Try fallback models if current model fails
                $is_model_error = strpos($error_code, 'model_not_found') !== false || 
                     strpos($error_message, 'does not exist') !== false ||
                     strpos($error_message, 'not have access') !== false;
                
                if ($is_model_error && !in_array($open_ai_model, $fallback_models)) {
                    // Try fallback models
                    foreach ($fallback_models as $fallback_model) {
                        $data['model'] = $fallback_model;
                        
                        $ch = curl_init($endpoint);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            "Content-Type: application/json",
                            "Authorization: Bearer " . $open_ai_secret_key
                        ));
                        
                        $fallback_response = curl_exec($ch);
                        curl_close($ch);
                        
                        if ($fallback_response) {
                            $fallback_response = json_decode($fallback_response, true);
                            if(isset($fallback_response['error'])){
                                // Check if fallback also has quota error
                                if (isset($fallback_response['error']['code']) && $fallback_response['error']['code'] == 'insufficient_quota') {
                                    $helpful_message = [
                                        'error' => [
                                            'message' => 'Your OpenAI API quota has been exceeded. Please check your billing and add credits to your account at https://platform.openai.com/account/billing',
                                            'type' => 'insufficient_quota',
                                            'code' => 'insufficient_quota',
                                            'help' => 'To resolve this: 1) Go to https://platform.openai.com/account/billing 2) Add payment method or top up credits 3) Wait a few minutes for the quota to update'
                                        ]
                                    ];
                                    return json_encode($helpful_message);
                                }
                                // Try next fallback model
                                continue;
                            }elseif(is_array($fallback_response)) {
                                // Success with fallback model - update database
                                Setting::where('type', 'open_ai_model')->update(['description' => $fallback_model]);
                                return $fallback_response['choices'][0]['message']['content'] ?? '';
                            }
                        }
                    }
                }
                
                // Return original error if no fallback worked
                return json_encode($response);
            }elseif(is_array($response)) {
                return $response['choices'][0]['message']['content'] ?? '';
            }
        }
    }
}
