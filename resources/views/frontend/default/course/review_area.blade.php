@php
    $reviews = App\Models\Review::join('users', 'reviews.user_id', '=', 'users.id')
        ->select(
            'reviews.*',
            'reviews.user_id as reviewer_id',
            'users.name as reviewer_name',
            'users.email as reviewer_email',
            'users.photo as reviewer_photo',
        )
        ->where('reviews.course_id', $course_details->id)
        ->where('reviews.review_type', 'course')
        ->latest('id')
        ->get();
@endphp

<div class="ps-box p-0 shadow-none animate__animated animate__fadeIn">
    <h4 class="fw-800 text-white mb-4"><i class="fi-rr-comment-quote text-vibrant-primary me-2"></i> {{ get_phrase('Student Reviews') }}</h4>
    
    <div class="review-container p-4 rounded-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); backdrop-filter: blur(10px);">
        <!-- Write Review Section -->
        <div class="write-review mb-5 pb-5 border-bottom border-white-10">
            <form action="{{ route('review.store') }}" method="POST">@csrf
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                    <p class="text-white opacity-80 mb-0 fw-bold">{{ get_phrase('Your rating for this course') }}</p>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <ul class="d-flex gap-1 rating-stars list-unstyled m-0">
                            @for ($i = 1; $i <= 5; $i++)
                                <li>
                                    <i class="fa-regular fa-star text-warning pointer fs-4" id="id-{{ $i }}"></i>
                                </li>
                            @endfor
                        </ul>
                        <button type="button" class="btn btn-link text-white opacity-40 hover-opacity-100 text-decoration-none small p-0" id="remove-stars">
                            <i class="fi-rr-trash"></i> {{ get_phrase('Reset') }}
                        </button>
                    </div>
                </div>

                <input type="hidden" name="rating" value="0">
                <input type="hidden" name="course_id" value="{{ $course_details->id }}">
                <textarea type="text" name="review" class="form-control mb-4 vibrant-textarea" rows="4"
                    placeholder="{{ get_phrase('Tell us about your experience with this course...') }}" required></textarea>
                <button type="submit" class="btn-vibrant w-100 py-3 rounded-pill fw-bold border-0">{{ get_phrase('Submit Review') }}</button>
            </form>
        </div>

        <!-- Reviews List -->
        <div class="reviews-list d-flex flex-column gap-4">
            @if (isset($reviews) && $reviews && $reviews->count() > 0)
                @foreach ($reviews as $review)
                    <div class="E-review p-4 rounded-4 transition-all" id="review-{{ $review->id }}" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.03);">
                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-4 mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ get_image($review->reviewer_photo) }}" class="rounded-circle" width="50" height="50" alt="reviewer-img" style="border: 2px solid var(--vibrant-primary);">
                                <div>
                                    <h6 class="text-white fw-bold mb-1">{{ $review->reviewer_name }}</h6>
                                    <div class="d-flex text-warning gap-1 small">
                                        @for ($i = 0; $i < 5; $i++)
                                            <i class="{{ $i < $review->rating ? 'fa-solid fa-star' : 'fa-regular fa-star' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column align-items-end">
                                <p class="text-white opacity-30 small mb-2">{{ date('d M, Y', strtotime($review->created_at)) }}</p>
                                @auth
                                    @if(auth()->user()->id == $review->reviewer_id)
                                        <div class="d-flex gap-3">
                                            <a onclick="ajaxModal('{{ route('modal', ['frontend.default.course.review_edit', 'id' => $review]) }}', '{{ get_phrase('Edit review') }}')"
                                                class="text-vibrant-accent text-decoration-none small fw-bold" href="javascript: void(0);"><i class="fi-rr-edit me-1"></i>{{ get_phrase('Edit') }}</a>
                                            <a onclick="confirmModal('{{ route('review.delete', $review->id) }}')"
                                                class="text-danger text-decoration-none small fw-bold"
                                                href="javascript: void(0);"><i class="fi-rr-trash me-1"></i>{{ get_phrase('Delete') }}</a>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                        <p class="text-white opacity-80 mb-4 lh-lg">{{ $review->review }}</p>
                        
                        <div class="d-flex align-items-center gap-4 border-top border-white-5 pt-3">
                            @php
                                $status = null;
                                if(auth()->check()){
                                    $status = App\Models\LikeDislikeReview::where('review_id', $review->id)
                                        ->where('user_id', auth()->user()->id)
                                        ->first();
                                }
                                $total_likes = App\Models\LikeDislikeReview::where('review_id', $review->id)->where('liked', 1)->count();
                                $total_dislikes = App\Models\LikeDislikeReview::where('review_id', $review->id)->where('disliked', 1)->count();
                            @endphp
                            <a href="{{ route('review.like', $review->id) }}" class="review-action d-flex align-items-center gap-2 @if (isset($status) && $status->liked == 1) active @endif">
                                <i class="fi-rr-thumbs-up"></i>
                                <span>{{ $total_likes }}</span>
                            </a>
                            <a href="{{ route('review.dislike', $review->id) }}" class="review-action d-flex align-items-center gap-2 @if (isset($status) && $status->disliked == 1) active @endif">
                                <i class="fi-rr-thumbs-down"></i>
                                <span>{{ $total_dislikes }}</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-5 opacity-40">
                    <i class="fi-rr-chat-dots fs-1 d-block mb-3"></i>
                    {{ get_phrase('No reviews yet. Be the first to share your experience!') }}
                </div>
            @endif
        </div>

        @if (isset($reviews) && $reviews && $reviews->count() > 6)
            <div class="text-center mt-5">
                <a href="javascript: void(0);" class="btn-vibrant-outline px-5 py-3 rounded-pill fw-bold d-inline-flex align-items-center gap-2" id="see-more">
                    {{ get_phrase('See More Reviews') }} <i class="fi-rr-arrow-small-down fs-4 mt-1"></i>
                </a>
            </div>
        @endif
    </div>
</div>

@push('js')
    <script>
        "use strict";
        $(document).ready(function() {
            let rating_stars = $('.rating-stars i');

            rating_stars.on('click', function(e) {
                e.preventDefault();
                let star = $(this).attr('id').substring(3);
                $('.write-review input[name="rating"]').val(star);

                rating_stars.removeClass('fa-solid fa-star fa-regular').addClass('fa-regular fa-star');
                for (let i = 1; i <= star; i++) {
                    $('#id-' + i).removeClass('fa-regular').addClass('fa-solid');
                }
            });

            $('#remove-stars').on('click', function(e) {
                e.preventDefault();
                rating_stars.removeClass('fa-solid fa-star fa-regular').addClass('fa-regular fa-star');
                $('.write-review input[name="rating"]').val(0);
            });

            $('#see-more').on('click', function(e) {
                e.preventDefault();
                $(this).toggleClass('active');

                let list = $('.reviews-list');
                
                if ($(this).hasClass('active')) {
                    list.css('max-height', 'none');
                    $(this).html('{{ get_phrase('Show Less') }} <i class="fi-rr-arrow-small-up fs-4 mt-1"></i>');
                } else {
                    list.css('max-height', 'auto');
                    $(this).html('{{ get_phrase('See More Reviews') }} <i class="fi-rr-arrow-small-down fs-4 mt-1"></i>');
                }
            });
        });
    </script>
@endpush
