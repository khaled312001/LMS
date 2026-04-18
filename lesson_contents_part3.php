<?php
require_once __DIR__ . '/slide_template.php';

/**
 * Lessons 9-14 — React, Storefront UI, PHP, MySQL, Laravel.
 */

function lesson_09_content(): string {
    $T = 'SlideTemplate'; $total = 22;
    $p = [];
    $p[] = $T::cover(9, 24,
        'TypeScript & Modern React 19 with Hooks and Context',
        'Pure JavaScript rots at scale. TypeScript + React 19 is the production stack powering Shopify, Stripe, Vercel and Next.js. Let\'s make you proficient.',
        'Module 2', '4h 30m');

    $p[] = $T::slide(2, $total, 'Why TypeScript', $T::bulletList([
        'Catches 40% of bugs before they happen (Airbnb engineering study)',
        'Self-documenting — your editor knows every prop and return type',
        'Refactor with confidence — rename a field, the compiler finds every caller',
        'Adopted by the entire React/Next.js ecosystem',
        'Runs anywhere JS runs (Node, browser, Deno, Bun)',
    ]));

    $p[] = $T::slide(3, $total, 'TypeScript in 5 Minutes',
        $T::codeBlock(
"// Basic types
let name: string = 'Alice';
let age: number = 30;
let isPro: boolean = true;
let tags: string[] = ['admin', 'staff'];
let point: [number, number] = [1, 2];       // tuple

// Interfaces for shapes
interface User {
  id: number;
  email: string;
  name?: string;           // optional
  readonly createdAt: Date;
}

// Function types
function greet(user: User): string {
  return `Hi \${user.name ?? 'friend'}`;
}

// Unions & narrowing
type Role = 'admin' | 'student' | 'instructor';
function welcome(role: Role) { /* … */ }", 'typescript'));

    $p[] = $T::slide(4, $total, 'Generics — Functions That Work For Any Type',
        $T::codeBlock(
"function first<T>(arr: T[]): T | undefined {
  return arr[0];
}

const n = first<number>([1, 2, 3]);   // number
const s = first(['a', 'b']);          // string (inferred)

// Generic React component
interface ListProps<T> {
  items: T[];
  render: (item: T) => React.ReactNode;
}

function List<T>({ items, render }: ListProps<T>) {
  return <ul>{items.map((i, k) => <li key={k}>{render(i)}</li>)}</ul>;
}", 'typescript'));

    $p[] = $T::slide(5, $total, 'Utility Types You Will Use Weekly',
        $T::table(['Type', 'What it does'], [
            ['<code class="sba-inline">Partial&lt;T&gt;</code>', 'Makes every property optional'],
            ['<code class="sba-inline">Required&lt;T&gt;</code>', 'Makes every property required'],
            ['<code class="sba-inline">Pick&lt;T, K&gt;</code>', 'Keeps only the listed keys'],
            ['<code class="sba-inline">Omit&lt;T, K&gt;</code>', 'Removes the listed keys'],
            ['<code class="sba-inline">Record&lt;K, V&gt;</code>', 'Object type with keys K and values V'],
            ['<code class="sba-inline">ReturnType&lt;f&gt;</code>', 'The return type of a function'],
            ['<code class="sba-inline">Awaited&lt;P&gt;</code>', 'Unwraps a Promise'],
        ]));

    $p[] = $T::slide(6, $total, 'Setting Up a React 19 + Vite Project',
        $T::codeBlock(
"npm create vite@latest my-app -- --template react-ts
cd my-app
npm install
npm run dev        # open http://localhost:5173", 'bash') .
        $T::paragraph('Vite replaces Create React App. Instant hot-reload, native TypeScript, tiny output.'));

    $p[] = $T::slide(7, $total, 'Your First Component',
        $T::codeBlock(
"// src/components/Hello.tsx
interface Props {
  name: string;
  age?: number;
}

export function Hello({ name, age = 0 }: Props) {
  return (
    <section>
      <h1>Hello, {name}!</h1>
      {age > 0 && <p>You are {age} years old.</p>}
    </section>
  );
}

// src/App.tsx
import { Hello } from './components/Hello';
export default function App() {
  return <Hello name=\"Alice\" age={30} />;
}", 'typescript'));

    $p[] = $T::slide(8, $total, 'JSX — What You Need To Know',
        $T::bulletList([
            'Components must return a <b>single</b> root element (or a <code class="sba-inline">&lt;&gt;...&lt;/&gt;</code> fragment)',
            'Use <code class="sba-inline">className</code> (not <code class="sba-inline">class</code>) and <code class="sba-inline">htmlFor</code> (not <code class="sba-inline">for</code>)',
            'Inline CSS is an object: <code class="sba-inline">style={{ color: "red" }}</code>',
            'Render lists with <code class="sba-inline">items.map(i =&gt; &lt;li key={i.id}&gt;…&lt;/li&gt;)</code> — <b>always</b> a key',
            'Event handlers are camelCase: <code class="sba-inline">onClick</code>, <code class="sba-inline">onChange</code>',
        ]));

    $p[] = $T::slide(9, $total, 'The Essential Hooks',
        $T::codeBlock(
"// State
const [count, setCount] = useState(0);

// Side effects
useEffect(() => {
  const id = setInterval(() => setCount(c => c + 1), 1000);
  return () => clearInterval(id);              // cleanup
}, []);                                        // run once

// Memoised value / function
const doubled = useMemo(() => count * 2, [count]);
const handle  = useCallback(() => setCount(0), []);

// Ref — direct DOM access or mutable value
const input = useRef<HTMLInputElement>(null);
useEffect(() => { input.current?.focus(); }, []);", 'typescript'));

    $p[] = $T::slide(10, $total, 'useState Patterns',
        $T::codeBlock(
"// Primitives
const [open, setOpen] = useState(false);

// Objects — always spread when updating
const [user, setUser] = useState({ name: '', email: '' });
setUser(u => ({ ...u, name: 'Alice' }));

// Functional updater for correctness under closures
setCount(c => c + 1);                 // safer than setCount(count + 1)

// Derived state — compute in render, don't store it
const isValid = email.includes('@');  // no useState needed", 'typescript'));

    $p[] = $T::slide(11, $total, 'useEffect — Rules Of Engagement',
        $T::callout('warning', 'The #1 React mistake',
            'Running fetches in useEffect without a cleanup function. In React 19 with Strict Mode you will fire two requests and see duplicate state.') .
        $T::codeBlock(
"useEffect(() => {
  let cancelled = false;

  async function load() {
    const data = await fetchUser(id);
    if (!cancelled) setUser(data);        // guard
  }

  load();
  return () => { cancelled = true; };     // cleanup
}, [id]);                                 // re-run when id changes", 'typescript'));

    $p[] = $T::slide(12, $total, 'Context — Share State Without Prop Drilling',
        $T::codeBlock(
"// auth-context.tsx
import { createContext, useContext, useState, ReactNode } from 'react';

interface AuthCtx {
  user: User | null;
  login: (u: User) => void;
  logout: () => void;
}
const AuthContext = createContext<AuthCtx | null>(null);

export function AuthProvider({ children }: { children: ReactNode }) {
  const [user, setUser] = useState<User | null>(null);
  return (
    <AuthContext.Provider value={{
      user,
      login: setUser,
      logout: () => setUser(null),
    }}>
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth() {
  const ctx = useContext(AuthContext);
  if (!ctx) throw new Error('useAuth must be inside AuthProvider');
  return ctx;
}", 'typescript'));

    $p[] = $T::slide(13, $total, 'Forms With react-hook-form + zod',
        $T::codeBlock(
"import { useForm } from 'react-hook-form';
import { zodResolver } from '@hookform/resolvers/zod';
import { z } from 'zod';

const schema = z.object({
  email:    z.string().email(),
  password: z.string().min(12),
});
type FormData = z.infer<typeof schema>;

function LoginForm() {
  const { register, handleSubmit, formState:{ errors } } =
    useForm<FormData>({ resolver: zodResolver(schema) });

  return (
    <form onSubmit={handleSubmit(login)}>
      <input {...register('email')} />
      {errors.email && <p>{errors.email.message}</p>}
      <input type=\"password\" {...register('password')} />
      <button>Sign in</button>
    </form>
  );
}", 'typescript'));

    $p[] = $T::slide(14, $total, 'Fetching With TanStack Query',
        $T::codeBlock(
"import { useQuery } from '@tanstack/react-query';

function ProductList() {
  const { data, isPending, error } = useQuery({
    queryKey: ['products'],
    queryFn:  () => fetch('/api/products').then(r => r.json()),
  });

  if (isPending) return <Spinner/>;
  if (error)     return <p>Failed: {error.message}</p>;
  return (
    <ul>{data.map(p => <li key={p.id}>{p.name}</li>)}</ul>
  );
}", 'typescript'));

    $p[] = $T::slide(15, $total, 'React Router v7',
        $T::codeBlock(
"import { createBrowserRouter, RouterProvider, Link } from 'react-router-dom';

const router = createBrowserRouter([
  { path: '/',          element: <Home/> },
  { path: '/products',  element: <Products/> },
  { path: '/products/:id', element: <Product/> },
  { path: '*',          element: <NotFound/> },
]);

export default function App() { return <RouterProvider router={router}/>; }", 'typescript'));

    $p[] = $T::slide(16, $total, 'Component Composition vs Inheritance',
        $T::callout('info', 'React philosophy', 'React never uses inheritance. You <b>compose</b> small components.') .
        $T::codeBlock(
"// Bad: huge component with everything
function Dashboard({ user, stats, notifications }) { /* 500 lines */ }

// Good: compose from smaller pieces
function Dashboard() {
  return (
    <Layout>
      <Header/>
      <StatsPanel/>
      <NotificationList/>
    </Layout>
  );
}", 'typescript'));

    $p[] = $T::slide(17, $total, 'Performance Tips',
        $T::bulletList([
            '<b>useMemo</b> only for expensive calculations',
            '<b>React.memo</b> only when profiler shows re-renders',
            '<b>useCallback</b> when passing callbacks to memoised children',
            'Virtualise long lists with <code class="sba-inline">react-virtuoso</code> or TanStack Virtual',
            'Split your bundle with <code class="sba-inline">React.lazy + Suspense</code>',
        ]));

    $p[] = $T::slide(18, $total, 'Accessibility in React',
        $T::codeBlock(
"// Every interactive element is a real <button>, not a <div>
<button onClick={open} aria-label=\"Add to cart\">
  <ShoppingCartIcon aria-hidden=\"true\"/>
</button>

// Announce dynamic updates
<div role=\"status\" aria-live=\"polite\">
  {items.length} items in cart
</div>

// Focus management after navigation
useEffect(() => {
  mainHeading.current?.focus();
}, [location.pathname]);", 'typescript'));

    $p[] = $T::slide(19, $total, 'React 19 New Features',
        $T::bulletList([
            '<b>Actions</b> — pass async functions to <code class="sba-inline">&lt;form action={…}&gt;</code>',
            '<b>useFormStatus</b> & <b>useActionState</b> — loading/error UI for free',
            '<b>useOptimistic</b> — UI updates before the server responds',
            '<b>use()</b> — unwrap promises directly in components with Suspense',
            'Asset preloading built-in',
            'Server Components ready out of the box (with Next.js)',
        ]));

    $p[] = $T::slide(20, $total, 'Prompting AI for React',
        $T::codeBlock(
"ROLE:    Senior React engineer.
STACK:   React 19 + TypeScript + Tailwind + TanStack Query.
TASK:    Build <ProductCard> that shows image, name, price,
         and 'Add to cart' button. Add to cart uses a mutation
         from /api/cart. Loading and error states handled.
RULES:   - Strict TypeScript
         - WCAG AA accessible
         - Responsive (mobile: column, md: row)
         - Compose with <Card> from shadcn/ui
OUTPUT:  One .tsx file + a short sample usage snippet.", 'prompt'));

    $p[] = $T::slide(21, $total, 'Key Takeaways', $T::bulletList([
        'TypeScript turns runtime bugs into compile-time errors',
        'React is functional — hooks replace class state',
        'useState + useEffect + Context cover 90% of needs',
        'Use TanStack Query for server state, not Redux',
        'Compose small components; never write 500-line ones',
    ]), 'sba-recap');

    $p[] = $T::slide(22, $total, 'Up Next — Lesson 10',
        $T::lead('Theory is complete. Next we build a real shop: <b>React + TypeScript Storefront UI with AI</b>.'));

    return $T::deckOpen() . implode("\n", $p) . $T::deckClose();
}

function lesson_10_content(): string {
    $T = 'SlideTemplate'; $total = 22;
    $p = [];
    $p[] = $T::cover(10, 24,
        'Building a React + TypeScript Storefront UI with AI',
        'Assemble a production-style e-commerce storefront UI: product grid, cart drawer, checkout flow, responsive nav — all in React 19 + TypeScript + Tailwind + shadcn/ui.',
        'Module 2', '5h');

    $p[] = $T::slide(2, $total, 'What We Build',
        $T::unsplashImage('online store shopping cart website', 'E-commerce storefront') .
        $T::bulletList([
            'Responsive navbar with cart badge',
            'Product grid with hover effects and skeleton loaders',
            'Product detail page with image gallery + variants',
            'Cart drawer (slide-out) with quantity stepper',
            'Multi-step checkout (address → shipping → payment)',
            'Order-confirmation page',
            'Dark mode toggle with localStorage persistence',
        ]));

    $p[] = $T::slide(3, $total, 'Project Setup',
        $T::codeBlock(
"npm create vite@latest storefront -- --template react-ts
cd storefront
npm i tailwindcss@4 @tailwindcss/vite
npm i react-router-dom @tanstack/react-query zustand
npm i react-hook-form zod @hookform/resolvers
npm i lucide-react clsx

# shadcn/ui CLI
npx shadcn@latest init
npx shadcn@latest add button card dialog input label sheet", 'bash'));

    $p[] = $T::slide(4, $total, 'Domain Types (types/shop.ts)',
        $T::codeBlock(
"export interface Product {
  id:          string;
  slug:        string;
  name:        string;
  description: string;
  price:       number;   // cents
  image:       string;
  category:    string;
  rating:      number;
  stock:       number;
}

export interface CartLine {
  product:  Product;
  quantity: number;
}

export interface Address {
  name:       string;
  line1:      string;
  city:       string;
  postalCode: string;
  country:    string;
}", 'typescript'));

    $p[] = $T::slide(5, $total, 'Cart Store With Zustand',
        $T::codeBlock(
"import { create } from 'zustand';
import { persist } from 'zustand/middleware';

interface State {
  lines: CartLine[];
  add:    (p: Product, qty?: number) => void;
  remove: (id: string) => void;
  setQty: (id: string, qty: number) => void;
  clear:  () => void;
  total:  () => number;
}

export const useCart = create<State>()(persist(
  (set, get) => ({
    lines: [],
    add: (p, qty = 1) => set(s => {
      const existing = s.lines.find(l => l.product.id === p.id);
      if (existing) existing.quantity += qty;
      else s.lines.push({ product: p, quantity: qty });
      return { lines: [...s.lines] };
    }),
    remove: (id) => set(s => ({ lines: s.lines.filter(l => l.product.id !== id) })),
    setQty: (id, qty) => set(s => ({
      lines: s.lines.map(l => l.product.id === id ? { ...l, quantity: qty } : l)
    })),
    clear: () => set({ lines: [] }),
    total: () => get().lines.reduce((t, l) => t + l.product.price * l.quantity, 0),
  }),
  { name: 'cart-v1' }
));", 'typescript'));

    $p[] = $T::slide(6, $total, 'Responsive Navbar',
        $T::codeBlock(
"import { ShoppingCart, Menu } from 'lucide-react';
import { useCart } from '../stores/cart';

export function Navbar() {
  const count = useCart(s => s.lines.reduce((t, l) => t + l.quantity, 0));
  return (
    <header className=\"sticky top-0 z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur border-b\">
      <div className=\"max-w-6xl mx-auto px-4 h-16 flex items-center justify-between\">
        <a href=\"/\" className=\"text-xl font-bold\">SwissShop</a>
        <nav className=\"hidden md:flex gap-6\">
          <a href=\"/products\">Products</a>
          <a href=\"/about\">About</a>
        </nav>
        <button className=\"relative\" aria-label=\"Open cart\">
          <ShoppingCart/>
          {count > 0 && (
            <span className=\"absolute -top-2 -right-2 bg-pink-500 text-white
                             rounded-full text-xs h-5 w-5 flex items-center justify-center\">
              {count}
            </span>
          )}
        </button>
      </div>
    </header>
  );
}", 'typescript'));

    $p[] = $T::slide(7, $total, 'Product Grid with Skeleton',
        $T::codeBlock(
"function ProductGrid() {
  const { data, isPending } = useQuery({
    queryKey: ['products'],
    queryFn:  () => fetch('/api/products').then(r => r.json() as Promise<Product[]>),
  });

  if (isPending) return <GridSkeleton/>;
  return (
    <div className=\"grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6\">
      {data!.map(p => <ProductCard key={p.id} product={p}/>)}
    </div>
  );
}

function GridSkeleton() {
  return (
    <div className=\"grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6\">
      {Array.from({length: 8}).map((_, i) => (
        <div key={i} className=\"h-64 rounded-xl bg-slate-200 dark:bg-slate-700 animate-pulse\"/>
      ))}
    </div>
  );
}", 'typescript'));

    $p[] = $T::slide(8, $total, 'ProductCard Component',
        $T::codeBlock(
"export function ProductCard({ product }: { product: Product }) {
  const add = useCart(s => s.add);
  return (
    <article className=\"group rounded-xl overflow-hidden border hover:shadow-lg transition\">
      <img src={product.image} alt={product.name}
           className=\"aspect-square w-full object-cover group-hover:scale-105 transition\"/>
      <div className=\"p-4\">
        <h3 className=\"font-semibold\">{product.name}</h3>
        <p className=\"mt-1 text-slate-600\">\${(product.price/100).toFixed(2)}</p>
        <button onClick={() => add(product)}
                className=\"mt-3 w-full bg-indigo-600 hover:bg-indigo-700 text-white
                           py-2 rounded-lg font-medium transition\">
          Add to Cart
        </button>
      </div>
    </article>
  );
}", 'typescript'));

    $p[] = $T::slide(9, $total, 'Cart Drawer (shadcn Sheet)',
        $T::codeBlock(
"import { Sheet, SheetContent, SheetHeader, SheetTitle } from '@/components/ui/sheet';

export function CartDrawer({ open, onOpenChange }: { open: boolean; onOpenChange: (o: boolean) => void }) {
  const lines = useCart(s => s.lines);
  const total = useCart(s => s.total());
  return (
    <Sheet open={open} onOpenChange={onOpenChange}>
      <SheetContent className=\"flex flex-col\">
        <SheetHeader><SheetTitle>Your Cart</SheetTitle></SheetHeader>
        <ul className=\"flex-1 space-y-4 overflow-y-auto\">
          {lines.map(l => <CartLineRow key={l.product.id} line={l}/>)}
        </ul>
        <div className=\"border-t pt-4\">
          <div className=\"flex justify-between text-lg font-bold\">
            <span>Total</span><span>\${(total/100).toFixed(2)}</span>
          </div>
          <Button asChild className=\"w-full mt-3\"><a href=\"/checkout\">Checkout</a></Button>
        </div>
      </SheetContent>
    </Sheet>
  );
}", 'typescript'));

    $p[] = $T::slide(10, $total, 'Multi-Step Checkout',
        $T::codeBlock(
"type Step = 'address' | 'shipping' | 'payment' | 'confirm';

export function Checkout() {
  const [step, setStep] = useState<Step>('address');
  const [data, setData] = useState<Partial<CheckoutData>>({});

  return (
    <div className=\"max-w-2xl mx-auto py-10 px-4\">
      <Stepper current={step}/>
      {step === 'address'  && <AddressStep  onDone={(d) => { setData({...data,...d}); setStep('shipping'); }}/>}
      {step === 'shipping' && <ShippingStep onDone={(d) => { setData({...data,...d}); setStep('payment'); }}/>}
      {step === 'payment'  && <PaymentStep  onDone={(d) => { setData({...data,...d}); setStep('confirm'); }}/>}
      {step === 'confirm'  && <ConfirmStep  data={data as CheckoutData}/>}
    </div>
  );
}", 'typescript'));

    $p[] = $T::slide(11, $total, 'Address Step With Validation',
        $T::codeBlock(
"const addressSchema = z.object({
  name:       z.string().min(2),
  line1:      z.string().min(3),
  city:       z.string().min(2),
  postalCode: z.string().regex(/^[A-Z0-9 -]{3,10}\$/),
  country:    z.string().length(2),
});

function AddressStep({ onDone }: { onDone: (d: Address) => void }) {
  const { register, handleSubmit, formState:{ errors } } =
    useForm<Address>({ resolver: zodResolver(addressSchema) });
  return (
    <form onSubmit={handleSubmit(onDone)} className=\"space-y-4\">
      <Field label=\"Full name\" error={errors.name} {...register('name')}/>
      <Field label=\"Address\"   error={errors.line1} {...register('line1')}/>
      <Field label=\"City\"      error={errors.city} {...register('city')}/>
      <Field label=\"ZIP\"       error={errors.postalCode} {...register('postalCode')}/>
      <Button type=\"submit\">Continue</Button>
    </form>
  );
}", 'typescript'));

    $p[] = $T::slide(12, $total, 'Dark Mode Toggle',
        $T::codeBlock(
"export function ThemeToggle() {
  const [theme, setTheme] = useState<'light'|'dark'>(() =>
    (localStorage.getItem('theme') as 'light'|'dark') ?? 'light');

  useEffect(() => {
    document.documentElement.classList.toggle('dark', theme === 'dark');
    localStorage.setItem('theme', theme);
  }, [theme]);

  return (
    <button onClick={() => setTheme(t => t === 'light' ? 'dark' : 'light')}
            aria-label=\"Toggle theme\">
      {theme === 'light' ? <Moon/> : <Sun/>}
    </button>
  );
}", 'typescript'));

    $p[] = $T::slide(13, $total, 'URL State — Filters & Sort',
        $T::codeBlock(
"import { useSearchParams } from 'react-router-dom';

export function ProductFilters() {
  const [params, setParams] = useSearchParams();
  const category = params.get('category') ?? 'all';
  const sort     = params.get('sort')     ?? 'newest';

  return (
    <div className=\"flex gap-3\">
      <select value={category} onChange={e => setParams(p => { p.set('category', e.target.value); return p; })}>
        <option value=\"all\">All</option>
        <option value=\"watches\">Watches</option>
        <option value=\"clothes\">Clothes</option>
      </select>
      <select value={sort} onChange={e => setParams(p => { p.set('sort', e.target.value); return p; })}>
        <option value=\"newest\">Newest</option>
        <option value=\"price-asc\">Price ↑</option>
        <option value=\"price-desc\">Price ↓</option>
      </select>
    </div>
  );
}", 'typescript'));

    $p[] = $T::slide(14, $total, 'Image Gallery With Keyboard Support',
        $T::codeBlock(
"function Gallery({ images }: { images: string[] }) {
  const [i, setI] = useState(0);
  return (
    <div>
      <img src={images[i]} alt=\"\" className=\"aspect-square w-full rounded-xl object-cover\"/>
      <div className=\"mt-3 flex gap-2\">
        {images.map((src, idx) => (
          <button key={src} onClick={() => setI(idx)}
                  aria-label={`Show image \${idx + 1}`}
                  className={clsx(\"h-16 w-16 rounded-lg overflow-hidden border-2\",
                                  idx === i ? \"border-indigo-600\" : \"border-transparent\")}>
            <img src={src} alt=\"\" className=\"h-full w-full object-cover\"/>
          </button>
        ))}
      </div>
    </div>
  );
}", 'typescript'));

    $p[] = $T::slide(15, $total, 'Loading & Empty States',
        $T::paragraph('Every async UI has four states: loading, empty, error, success. Handle them all.') .
        $T::codeBlock(
"if (isPending) return <ProductsSkeleton/>;
if (error)     return <ErrorBanner message={error.message} onRetry={refetch}/>;
if (products.length === 0) return <EmptyState title=\"No products\" cta=\"Browse categories\"/>;
return <ProductGrid products={products}/>;", 'typescript'));

    $p[] = $T::slide(16, $total, 'Testing The UI',
        $T::codeBlock(
"// cart.test.tsx
import { render, screen, fireEvent } from '@testing-library/react';
import { vi } from 'vitest';
import { ProductCard } from './ProductCard';
import { useCart } from '../stores/cart';

it('adds product to cart on click', () => {
  const fakeProduct = { id:'1', name:'Watch', price:1999, /* ... */ };
  render(<ProductCard product={fakeProduct as any}/>);
  fireEvent.click(screen.getByText(/add to cart/i));
  expect(useCart.getState().lines).toHaveLength(1);
});", 'typescript'));

    $p[] = $T::slide(17, $total, 'Prompt Patterns For This Build',
        $T::codeBlock(
"Prompt 1 — architecture:
  Generate the folder structure for a Vite + React 19 +
  TypeScript storefront with Tailwind, shadcn/ui, Zustand,
  React Query, React Router, Zod. Separate features/, shared/,
  app/, and types/.

Prompt 2 — a specific component:
  Implement ProductCard per /types/shop.ts Product interface.
  Tailwind only. Add accessible 'Add to cart' with aria-label.
  Use Zustand cart store shown below: <paste the store>.", 'prompt'));

    $p[] = $T::slide(18, $total, 'Folder Structure',
        $T::codeBlock(
"src/
├── app/          # router, providers
├── features/
│   ├── cart/
│   │   ├── store.ts
│   │   ├── CartDrawer.tsx
│   │   └── CartLineRow.tsx
│   ├── checkout/
│   └── products/
│       ├── api.ts
│       ├── ProductCard.tsx
│       └── ProductGrid.tsx
├── shared/
│   ├── components/  # Button, Field, Spinner
│   └── lib/         # utils, format, cn
└── types/", 'text'));

    $p[] = $T::slide(19, $total, 'Deploying The UI (Preview)',
        $T::codeBlock(
"npm run build             # builds /dist
npx vercel                # 30 seconds to a live URL
# or
npx netlify deploy --prod", 'bash') .
        $T::callout('info', 'Production deployment', 'We\'ll deploy the *full stack* version to Hostinger in Lesson 23.'));

    $p[] = $T::slide(20, $total, 'Common Pitfalls',
        $T::bulletList([
            'Storing server data in Zustand instead of TanStack Query',
            'Missing <code class="sba-inline">key</code> on list items — subtle bugs',
            'Calling setState inside render (infinite loop)',
            'Forgetting to depth-clone in Zustand updates',
            'Using <code class="sba-inline">index</code> as <code class="sba-inline">key</code> in reordered lists',
        ]));

    $p[] = $T::slide(21, $total, 'Key Takeaways', $T::bulletList([
        'Zustand for client state, TanStack Query for server state',
        'shadcn/ui gives you polished components in one command',
        'Forms use react-hook-form + zod for type-safe validation',
        'URL search params beat useState for filters (shareable + back button works)',
        'Every async UI = loading + empty + error + success',
    ]), 'sba-recap');

    $p[] = $T::slide(22, $total, 'Up Next — Lesson 11',
        $T::lead('Beautiful UI, nothing to render yet. Time for the backend. Next: <b>PHP 8 Fundamentals & Object-Oriented Programming</b>.'));

    return $T::deckOpen() . implode("\n", $p) . $T::deckClose();
}

function lesson_11_content(): string {
    $T = 'SlideTemplate'; $total = 22;
    $p = [];
    $p[] = $T::cover(11, 24,
        'PHP 8 Fundamentals & Object-Oriented Programming',
        'PHP runs 78% of the web. Modern PHP 8.3 is strongly typed, fast, and joyful. This lesson teaches you PHP as a first-class language — ready for Laravel in the next module.',
        'Module 3', '4h 30m');

    $p[] = $T::slide(2, $total, 'Why PHP in 2026', $T::bulletList([
        'WordPress, Laravel, Symfony, Magento, Shopify admin — all PHP',
        'Shared hosting everywhere (perfect for Hostinger deployments)',
        'PHP 8.3 is 3-5x faster than PHP 7',
        'Types, enums, readonly classes, first-class callables',
        'Huge ecosystem via Composer (PHP\'s npm)',
    ]));

    $p[] = $T::slide(3, $total, 'Hello World',
        $T::codeBlock(
"<?php
declare(strict_types=1);

echo 'Hello, ' . PHP_EOL;
echo \"Running PHP \" . PHP_VERSION . \"\\n\";

// Modern, short syntax
const TAX_RATE = 0.08;
\$total = 100 * (1 + TAX_RATE);
printf('Total: \$%.2f%s', \$total, PHP_EOL);", 'php') .
        $T::paragraph('Run: <code class="sba-inline">php hello.php</code>'));

    $p[] = $T::slide(4, $total, 'Variables & Types',
        $T::codeBlock(
"<?php
\$name  = 'Alice';              // string
\$age   = 30;                   // int
\$price = 99.99;                // float
\$isPro = true;                 // bool
\$tags  = ['laravel', 'php'];   // array

// Typed variables (with strict types)
function greet(string \$name, int \$age = 0): string {
    return \"Hi \$name (\$age)\";
}

echo greet('Alice', 30);", 'php'));

    $p[] = $T::slide(5, $total, 'Arrays — The Swiss Army Knife',
        $T::codeBlock(
"<?php
// Indexed
\$prices = [10, 20, 30];
\$prices[] = 40;                 // push

// Associative
\$user = ['name' => 'Alice', 'email' => 'a@x.com'];
\$user['age'] = 30;              // add/set

// Loop
foreach (\$prices as \$p)        echo \$p . \"\\n\";
foreach (\$user   as \$k => \$v)  echo \"\$k=\$v\\n\";

// Functional helpers
\$total  = array_sum(\$prices);
\$tax    = array_map(fn(\$p) => \$p * 1.08, \$prices);
\$costly = array_filter(\$prices, fn(\$p) => \$p > 15);", 'php'));

    $p[] = $T::slide(6, $total, 'Control Flow',
        $T::codeBlock(
"<?php
// if / elseif / else
if (\$age < 18)      echo 'minor';
elseif (\$age < 65)  echo 'adult';
else                 echo 'senior';

// Match expression (PHP 8+)
\$label = match(true) {
    \$age < 18  => 'minor',
    \$age < 65  => 'adult',
    default    => 'senior',
};

// Null coalescing + nullsafe
\$city = \$user->address?->city ?? 'Unknown';

// Loops
for (\$i = 0; \$i < 10; \$i++) { echo \$i; }
while (\$queue)        process(array_shift(\$queue));", 'php'));

    $p[] = $T::slide(7, $total, 'Functions',
        $T::codeBlock(
"<?php
// Regular
function add(int \$a, int \$b): int { return \$a + \$b; }

// Default + named args
function order(string \$sku, int \$qty = 1, bool \$giftWrap = false) {}
order(sku: 'ABC', giftWrap: true);

// Variadic
function sum(int ...\$nums): int { return array_sum(\$nums); }
sum(1, 2, 3);                             // 6

// Arrow function
\$double = fn(int \$x): int => \$x * 2;

// First-class callable
\$fn = strtoupper(...);
echo \$fn('hello');                         // HELLO", 'php'));

    $p[] = $T::slide(8, $total, 'Classes & Objects',
        $T::codeBlock(
"<?php
class Product {
    public function __construct(
        public readonly string \$id,
        public string \$name,
        public float  \$price,
        private int   \$stock = 0,
    ) {}

    public function inStock(): bool {
        return \$this->stock > 0;
    }

    public function reserve(int \$qty): void {
        if (\$qty > \$this->stock) throw new RuntimeException('OOS');
        \$this->stock -= \$qty;
    }
}

\$p = new Product(id: 'p1', name: 'Watch', price: 199, stock: 10);
\$p->reserve(2);
echo \$p->name;                              // Watch", 'php') .
        $T::callout('success', 'PHP 8 magic',
            'Constructor property promotion writes your class in 5 lines instead of 30.'));

    $p[] = $T::slide(9, $total, 'Inheritance & Interfaces',
        $T::codeBlock(
"<?php
interface Payable {
    public function total(): float;
}

abstract class Order implements Payable {
    abstract public function items(): array;
    public function total(): float {
        return array_sum(array_map(fn(\$i) => \$i->price, \$this->items()));
    }
}

class ShopOrder extends Order {
    public function __construct(private array \$lines) {}
    public function items(): array { return \$this->lines; }
}", 'php'));

    $p[] = $T::slide(10, $total, 'Enums (PHP 8.1+)',
        $T::codeBlock(
"<?php
enum OrderStatus: string {
    case Pending   = 'pending';
    case Paid      = 'paid';
    case Shipped   = 'shipped';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';

    public function label(): string {
        return match(\$this) {
            self::Pending   => 'Awaiting Payment',
            self::Paid      => 'Processing',
            self::Shipped   => 'In Transit',
            self::Delivered => 'Complete',
            self::Cancelled => 'Cancelled',
        };
    }
}

\$status = OrderStatus::Paid;
echo \$status->label();                     // Processing", 'php'));

    $p[] = $T::slide(11, $total, 'Namespaces & Autoloading',
        $T::codeBlock(
"<?php
// src/Models/Product.php
namespace App\\Models;

class Product {}

// composer.json
{
  \"autoload\": {
    \"psr-4\": { \"App\\\\\": \"src/\" }
  }
}

// index.php
require 'vendor/autoload.php';

use App\\Models\\Product;
\$p = new Product();", 'php') .
        $T::paragraph('Run <code class="sba-inline">composer dump-autoload</code> whenever you add a new file.'));

    $p[] = $T::slide(12, $total, 'Error Handling — Exceptions',
        $T::codeBlock(
"<?php
class InsufficientStockException extends RuntimeException {
    public function __construct(public readonly string \$sku) {
        parent::__construct(\"Out of stock: \$sku\");
    }
}

try {
    \$order->place();
} catch (InsufficientStockException \$e) {
    log_warn(\$e->sku);
    show_error('We ran out of that item.');
} catch (Throwable \$e) {
    report(\$e);
    show_error('Something went wrong.');
}", 'php'));

    $p[] = $T::slide(13, $total, 'Working With JSON',
        $T::codeBlock(
"<?php
// Encode
\$payload = ['user' => 'alice', 'cart' => [1, 2, 3]];
\$json = json_encode(\$payload, JSON_PRETTY_PRINT);

// Decode (array)
\$data = json_decode(\$json, true);

// Decode (object)
\$obj = json_decode(\$json);

// Sending a JSON response from a PHP script
header('Content-Type: application/json');
echo json_encode(['ok' => true]);", 'php'));

    $p[] = $T::slide(14, $total, 'Composer — PHP\'s Package Manager',
        $T::codeBlock(
"composer init                        # new project
composer require monolog/monolog     # install lib
composer update                      # update all
composer require --dev phpunit/phpunit
composer dump-autoload               # regenerate autoloader

# composer.json excerpt
{
  \"require\":      { \"monolog/monolog\": \"^3.0\" },
  \"require-dev\":  { \"phpunit/phpunit\": \"^10.0\" }
}", 'bash'));

    $p[] = $T::slide(15, $total, 'Working With Files',
        $T::codeBlock(
"<?php
\$text = file_get_contents('data.txt');
file_put_contents('copy.txt', strtoupper(\$text));

foreach (glob('uploads/*.jpg') as \$path) {
    \$size = filesize(\$path);
    echo basename(\$path) . \": \$size bytes\\n\";
}

// CSV reading
\$fh = fopen('users.csv', 'r');
while (\$row = fgetcsv(\$fh)) {
    [\$name, \$email] = \$row;
    insertUser(\$name, \$email);
}
fclose(\$fh);", 'php'));

    $p[] = $T::slide(16, $total, 'PDO — Database Access Without Frameworks',
        $T::codeBlock(
"<?php
\$pdo = new PDO(
    'mysql:host=localhost;dbname=shop;charset=utf8mb4',
    'root', '',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// Safe, parameterised query
\$stmt = \$pdo->prepare('SELECT * FROM products WHERE category = ? AND price < ?');
\$stmt->execute(['watches', 500]);
\$rows = \$stmt->fetchAll(PDO::FETCH_ASSOC);

// Insert
\$pdo->prepare('INSERT INTO users (email) VALUES (?)')->execute(['a@b.com']);", 'php') .
        $T::callout('danger', 'Never',
            'Never concatenate SQL with variables. Always use prepared statements.'));

    $p[] = $T::slide(17, $total, 'Built-in Dev Server',
        $T::codeBlock(
"# serve the current directory at http://localhost:8000
php -S localhost:8000

# serve a /public folder for projects that have an index.php router
php -S localhost:8000 -t public", 'bash'));

    $p[] = $T::slide(18, $total, 'PHP Tooling That Matters',
        $T::table(['Tool', 'Purpose'], [
            ['Composer', 'Dependencies'],
            ['PHPUnit', 'Testing'],
            ['PHPStan / Psalm', 'Static analysis'],
            ['PHP CS Fixer', 'Formatting'],
            ['Xdebug', 'Step debugger'],
            ['Pint', 'Laravel-native formatter (wraps PHP CS Fixer)'],
        ]));

    $p[] = $T::slide(19, $total, 'AI Prompts That Rock in PHP',
        $T::codeBlock(
"Generate a Cart class in PHP 8.3 with:
  - Constructor property promotion
  - readonly item records
  - add(Product \$p, int \$qty = 1)
  - remove(string \$sku)
  - total(): float (with 8% tax)
  - to_array(): array
Include full PHPDoc and strict types declared at the top.
Output: a single cart.php file — no prose.", 'prompt'));

    $p[] = $T::slide(20, $total, 'Hands-On Mini Project',
        $T::numberedList([
            'Build a Cart class per the prompt above',
            'Write a PHP-only CLI script that reads products.csv, adds 3 to cart, prints the total',
            'Convert it to an HTTP endpoint with the built-in server',
            'Add PDO to persist orders to MySQL (you\'ll set up MySQL in Lesson 12)',
        ]));

    $p[] = $T::slide(21, $total, 'Key Takeaways', $T::bulletList([
        'Modern PHP 8.3 has types, enums, readonly, and match',
        'Composer = npm for PHP — use PSR-4 autoloading',
        'PDO with prepared statements — never raw SQL',
        'The built-in dev server is perfect for local development',
        'OOP, interfaces, and enums prepare you for Laravel',
    ]), 'sba-recap');

    $p[] = $T::slide(22, $total, 'Up Next — Lesson 12',
        $T::lead('PHP without data is a calculator. Next: <b>MySQL Database Design, Relationships &amp; AI-generated Schemas</b>.'));

    return $T::deckOpen() . implode("\n", $p) . $T::deckClose();
}

function lesson_12_content(): string {
    $T = 'SlideTemplate'; $total = 21;
    $p = [];
    $p[] = $T::cover(12, 24,
        'MySQL Database Design, Relationships & AI-Generated Schemas',
        'Relational databases remain the backbone of transactional apps. Master MySQL 8 with design principles, SQL, indexes, and AI-driven schema generation for real projects.',
        'Module 3', '4h');

    $p[] = $T::slide(2, $total, 'Goals',
        $T::bulletList([
            'Design normalised tables for an e-commerce store',
            'Master CRUD SQL: SELECT, INSERT, UPDATE, DELETE',
            'Use JOINs, subqueries, GROUP BY, window functions',
            'Understand indexes and query performance',
            'Use AI to generate migrations & seed data',
        ]));

    $p[] = $T::slide(3, $total, 'Connecting',
        $T::codeBlock(
"mysql -u root -p                    # login
SHOW DATABASES;
CREATE DATABASE shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE shop;
SHOW TABLES;", 'sql'));

    $p[] = $T::slide(4, $total, 'Types You Will Actually Use',
        $T::table(['Type', 'Use for'], [
            ['BIGINT UNSIGNED', 'IDs, FKs'],
            ['VARCHAR(n)', 'Short text (≤ 255)'],
            ['TEXT / LONGTEXT', 'Long content'],
            ['DECIMAL(10,2)', 'Money (never FLOAT!)'],
            ['TIMESTAMP', 'Created/updated times'],
            ['JSON', 'Flexible structured fields'],
            ['ENUM', 'Fixed small sets'],
            ['BOOLEAN', '0/1 flags'],
        ]));

    $p[] = $T::slide(5, $total, 'Your First Table',
        $T::codeBlock(
"CREATE TABLE products (
    id            BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sku           VARCHAR(50)  NOT NULL UNIQUE,
    name          VARCHAR(255) NOT NULL,
    slug          VARCHAR(255) NOT NULL UNIQUE,
    description   TEXT,
    price_cents   INT UNSIGNED NOT NULL,
    stock         INT UNSIGNED NOT NULL DEFAULT 0,
    category_id   BIGINT UNSIGNED,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_products_category (category_id),
    INDEX idx_products_price    (price_cents)
);", 'sql'));

    $p[] = $T::slide(6, $total, 'The Three Relationship Types',
        $T::cardGrid([
            ['icon' => '1️⃣', 'title' => 'One-to-One', 'text' => 'User → Profile. Keep in same table unless profiles are huge.'],
            ['icon' => '🧩', 'title' => 'One-to-Many', 'text' => 'Category → Products. Child table holds the FK.', 'color' => 'sba-pink'],
            ['icon' => '🔗', 'title' => 'Many-to-Many', 'text' => 'Products ↔ Tags via a pivot table.', 'color' => 'sba-cyan'],
        ], 3));

    $p[] = $T::slide(7, $total, 'E-commerce Schema (ERD)',
        $T::codeBlock(
"users          (id, name, email, password, created_at)
addresses      (id, user_id→, line1, city, postal_code, country)
categories     (id, parent_id→, name, slug)
products       (id, sku, name, price_cents, stock, category_id→)
tags           (id, name)
product_tag    (product_id→, tag_id→)          -- pivot
orders         (id, user_id→, address_id→, status, total_cents, placed_at)
order_items    (id, order_id→, product_id→, qty, unit_price_cents)
reviews        (id, product_id→, user_id→, rating, body)", 'sql'));

    $p[] = $T::slide(8, $total, 'Foreign Keys In Practice',
        $T::codeBlock(
"CREATE TABLE order_items (
    id            BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id      BIGINT UNSIGNED NOT NULL,
    product_id    BIGINT UNSIGNED NOT NULL,
    qty           INT UNSIGNED    NOT NULL,
    unit_price_cents INT UNSIGNED NOT NULL,
    FOREIGN KEY (order_id)   REFERENCES orders(id)   ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
);", 'sql'));

    $p[] = $T::slide(9, $total, 'INSERT, UPDATE, DELETE',
        $T::codeBlock(
"INSERT INTO users (name, email, password)
VALUES ('Alice', 'a@x.com', '\$2y\$10\$...');

UPDATE products
SET price_cents = price_cents * 0.9
WHERE category_id = 3;

DELETE FROM reviews WHERE rating = 1 AND created_at < NOW() - INTERVAL 1 YEAR;", 'sql') .
        $T::callout('warning', 'Rule',
            'Always include a WHERE on UPDATE/DELETE. <code class="sba-inline">UPDATE users SET email = "x"</code> (no WHERE) will change <i>every</i> user.'));

    $p[] = $T::slide(10, $total, 'SELECT — The Query',
        $T::codeBlock(
"-- All watches under \$500, newest first, page 2 (20/page)
SELECT id, name, price_cents
FROM   products
WHERE  category_id = 3
  AND  price_cents < 50000
ORDER BY created_at DESC
LIMIT 20 OFFSET 20;

-- Aggregate: revenue per category this month
SELECT c.name, SUM(oi.qty * oi.unit_price_cents) AS revenue_cents
FROM   order_items oi
JOIN   products  p ON p.id = oi.product_id
JOIN   categories c ON c.id = p.category_id
JOIN   orders    o ON o.id = oi.order_id
WHERE  o.placed_at >= DATE_FORMAT(NOW(), '%Y-%m-01')
GROUP BY c.id
ORDER BY revenue_cents DESC;", 'sql'));

    $p[] = $T::slide(11, $total, 'JOINs',
        $T::table(['JOIN type', 'Returns'], [
            ['INNER JOIN', 'Rows that match on both sides'],
            ['LEFT JOIN', 'Every row from the left, NULL when no match on the right'],
            ['RIGHT JOIN', 'Opposite of LEFT'],
            ['FULL JOIN', 'Not in MySQL — use <code class="sba-inline">UNION</code> of LEFT + RIGHT'],
        ]) .
        $T::codeBlock(
"-- Customers who have placed an order
SELECT DISTINCT u.id, u.name
FROM   users u
INNER JOIN orders o ON o.user_id = u.id;

-- Customers who have NEVER placed an order
SELECT u.id, u.name
FROM   users u
LEFT JOIN orders o ON o.user_id = u.id
WHERE  o.id IS NULL;", 'sql'));

    $p[] = $T::slide(12, $total, 'Indexes — Fast Reads, Slower Writes',
        $T::codeBlock(
"-- Single-column
CREATE INDEX idx_products_slug ON products(slug);

-- Composite (order matters — used for filter combinations)
CREATE INDEX idx_orders_user_status ON orders(user_id, status);

-- Partial / prefix for long text
CREATE INDEX idx_products_name_prefix ON products(name(50));

-- See if a query uses your index
EXPLAIN SELECT * FROM products WHERE slug = 'my-watch';", 'sql') .
        $T::callout('info', 'Rule of thumb',
            'Every FK, every column used in WHERE or ORDER BY on large tables, should have an index.'));

    $p[] = $T::slide(13, $total, 'Transactions',
        $T::codeBlock(
"START TRANSACTION;

  UPDATE products SET stock = stock - 1 WHERE id = 42;
  INSERT INTO order_items (order_id, product_id, qty, unit_price_cents)
    VALUES (99, 42, 1, 19900);

  -- If anything is wrong, we roll back:
  -- ROLLBACK;

COMMIT;", 'sql') .
        $T::paragraph('Transactions guarantee all-or-nothing execution — essential for money, inventory, and transfers.'));

    $p[] = $T::slide(14, $total, 'Window Functions',
        $T::codeBlock(
"-- Rank products by revenue within each category
SELECT
  c.name AS category,
  p.name AS product,
  SUM(oi.qty) AS sold,
  RANK() OVER (PARTITION BY c.id ORDER BY SUM(oi.qty) DESC) AS rank_in_cat
FROM order_items oi
JOIN products   p ON p.id = oi.product_id
JOIN categories c ON c.id = p.category_id
GROUP BY c.id, p.id;", 'sql'));

    $p[] = $T::slide(15, $total, 'JSON Columns (MySQL 8)',
        $T::codeBlock(
"CREATE TABLE events (
  id         BIGINT AUTO_INCREMENT PRIMARY KEY,
  payload    JSON NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO events (payload)
VALUES ('{\"type\":\"signup\",\"user\":123,\"plan\":\"pro\"}');

SELECT id, payload->>'\$.type'  AS type,
           payload->>'\$.plan'  AS plan
FROM events;

-- Index a JSON field
ALTER TABLE events
  ADD INDEX idx_event_type ((CAST(payload->>'\$.type' AS CHAR(50))));", 'sql'));

    $p[] = $T::slide(16, $total, 'Backups & Restores',
        $T::codeBlock(
"# Dump a full database
mysqldump -u root -p shop > shop-2026-04-18.sql

# Restore
mysql -u root -p shop < shop-2026-04-18.sql

# Only specific tables
mysqldump shop users orders > users-orders.sql

# Safer option — schema only, no data
mysqldump --no-data shop > schema.sql", 'bash') .
        $T::callout('warning', 'Rule',
            'Automate daily backups on Hostinger (covered in lesson 24). Test the restore before you need it.'));

    $p[] = $T::slide(17, $total, 'AI Prompts for Schemas',
        $T::codeBlock(
"Design a complete MySQL 8 schema for an e-commerce store with:
 - Users, addresses
 - Products with categories, tags, variants (size/color)
 - Orders, order items, payments, shipments
 - Reviews with aggregate rating on products

Requirements:
 - utf8mb4, InnoDB
 - DECIMAL(10,2) for all money fields
 - Indexes on every FK + search-common columns
 - ON DELETE strategies documented
 - Seed data: 3 users, 20 products, 5 categories, 10 orders

Output: a single migrations.sql file only.", 'prompt'));

    $p[] = $T::slide(18, $total, 'MySQL Security Basics',
        $T::bulletList([
            'Create app-specific users; never use <code class="sba-inline">root</code> from apps',
            'Grant least-privilege: <code class="sba-inline">GRANT SELECT, INSERT, UPDATE, DELETE ON shop.* TO ...</code>',
            'Always use prepared statements in app code',
            'Validate input types in app layer too',
            'Back up every night; restore-test monthly',
        ]));

    $p[] = $T::slide(19, $total, 'GUI Tools',
        $T::table(['Tool', 'Price', 'Strength'], [
            ['MySQL Workbench', 'Free', 'Official'],
            ['TablePlus', '\$79 lifetime', 'Beautiful UI'],
            ['DBeaver', 'Free', 'Works with every DB'],
            ['phpMyAdmin', 'Free', 'Built into Hostinger'],
            ['DataGrip', 'Paid', 'Industrial strength'],
        ]));

    $p[] = $T::slide(20, $total, 'Key Takeaways', $T::bulletList([
        'Normalise to 3NF, denormalise only when needed',
        'Always parametrize queries — never string-concat',
        'Indexes speed reads but slow writes — measure with EXPLAIN',
        'Use transactions for any multi-statement business logic',
        'AI can generate entire schemas — always review for indexes and types',
    ]), 'sba-recap');

    $p[] = $T::slide(21, $total, 'Up Next — Lesson 13',
        $T::lead('Schema ready. Time to meet the framework that ships 70% of PHP SaaS: <b>Laravel 11</b>.'));

    return $T::deckOpen() . implode("\n", $p) . $T::deckClose();
}

function lesson_13_content(): string {
    $T = 'SlideTemplate'; $total = 22;
    $p = [];
    $p[] = $T::cover(13, 24,
        'Laravel 11 Deep Dive — Eloquent, Blade, Auth & API',
        'Laravel is PHP\'s most loved framework — elegant, productive, and deeply powered by AI tooling. In this lesson you master routing, Eloquent, Blade, authentication, and REST API building.',
        'Module 3', '5h 30m');

    $p[] = $T::slide(2, $total, 'Why Laravel', $T::bulletList([
        'Beautiful, opinionated conventions that make teams productive',
        'Eloquent ORM — expressive queries, relationships, events',
        'Built-in auth, queues, caching, broadcasting, storage, jobs',
        'Artisan CLI: scaffolding, migrations, generators',
        'Huge ecosystem: Breeze, Jetstream, Livewire, Inertia, Filament',
    ]));

    $p[] = $T::slide(3, $total, 'Creating A Laravel Project',
        $T::codeBlock(
"composer create-project laravel/laravel my-shop
cd my-shop
php artisan serve           # http://localhost:8000

# Or with the global installer
composer global require laravel/installer
laravel new my-shop --git

# Configure .env
DB_DATABASE=shop
DB_USERNAME=root
DB_PASSWORD=secret
php artisan migrate", 'bash'));

    $p[] = $T::slide(4, $total, 'Laravel Anatomy',
        $T::codeBlock(
"my-shop/
├── app/
│   ├── Http/Controllers/
│   ├── Models/
│   └── Providers/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── public/          # index.php — your webroot
├── resources/
│   ├── views/       # Blade templates
│   ├── js/
│   └── css/
├── routes/
│   ├── web.php
│   └── api.php
├── tests/
└── .env", 'text'));

    $p[] = $T::slide(5, $total, 'Routing Basics',
        $T::codeBlock(
"// routes/web.php
use App\\Http\\Controllers\\ProductController;

Route::get('/',              [HomeController::class, 'index']);
Route::get('/products',      [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show'])->whereNumber('id');

// Grouped with middleware
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::resource('products', AdminProductController::class);
});", 'php'));

    $p[] = $T::slide(6, $total, 'Controllers',
        $T::codeBlock(
"<?php
namespace App\\Http\\Controllers;

use App\\Models\\Product;
use Illuminate\\Http\\Request;

class ProductController extends Controller
{
    public function index(Request \$request)
    {
        \$products = Product::query()
            ->when(\$request->category, fn(\$q, \$c) => \$q->where('category_id', \$c))
            ->latest()
            ->paginate(20);

        return view('products.index', compact('products'));
    }

    public function show(Product \$product)   // route-model binding
    {
        return view('products.show', compact('product'));
    }
}", 'php'));

    $p[] = $T::slide(7, $total, 'Eloquent Models',
        $T::codeBlock(
"<?php
namespace App\\Models;

use Illuminate\\Database\\Eloquent\\Model;

class Product extends Model
{
    protected \$fillable = ['name', 'price_cents', 'stock', 'category_id'];
    protected \$casts    = ['price_cents' => 'int'];

    public function category() { return \$this->belongsTo(Category::class); }
    public function reviews()  { return \$this->hasMany(Review::class); }
    public function tags()     { return \$this->belongsToMany(Tag::class); }

    public function scopeInStock(\$q) { return \$q->where('stock', '>', 0); }
}

// Usage:
\$list = Product::inStock()->with('category')->get();", 'php'));

    $p[] = $T::slide(8, $total, 'Migrations',
        $T::codeBlock(
"// database/migrations/2026_04_18_create_products_table.php
return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint \$t) {
            \$t->id();
            \$t->string('sku')->unique();
            \$t->string('name');
            \$t->string('slug')->unique();
            \$t->text('description')->nullable();
            \$t->unsignedInteger('price_cents');
            \$t->unsignedInteger('stock')->default(0);
            \$t->foreignId('category_id')->constrained();
            \$t->timestamps();
        });
    }
};
// Run: php artisan migrate", 'php'));

    $p[] = $T::slide(9, $total, 'Seeders & Factories',
        $T::codeBlock(
"// database/factories/ProductFactory.php
class ProductFactory extends Factory {
    public function definition(): array {
        return [
            'sku'         => strtoupper(fake()->bothify('??-####')),
            'name'        => fake()->words(3, true),
            'slug'        => fake()->unique()->slug(),
            'price_cents' => fake()->numberBetween(1000, 50000),
            'stock'       => fake()->numberBetween(0, 200),
            'category_id' => Category::factory(),
        ];
    }
}
// Seed:
php artisan tinker
>>> Product::factory(100)->create();", 'php'));

    $p[] = $T::slide(10, $total, 'Blade Templates',
        $T::codeBlock(
"{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html>
<head>
  <title>@yield('title') – SwissShop</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  @include('partials.nav')
  <main>@yield('content')</main>
</body>
</html>

{{-- resources/views/products/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Products')
@section('content')
  <h1>Products</h1>
  @forelse (\$products as \$p)
    <article>
      <h2>{{ \$p->name }}</h2>
      <p>\${{ number_format(\$p->price_cents / 100, 2) }}</p>
    </article>
  @empty
    <p>No products yet.</p>
  @endforelse
  {{ \$products->links() }}
@endsection", 'php'));

    $p[] = $T::slide(11, $total, 'Forms & Validation',
        $T::codeBlock(
"public function store(Request \$request)
{
    \$data = \$request->validate([
        'name'        => ['required','string','max:255'],
        'price_cents' => ['required','integer','min:1'],
        'stock'       => ['required','integer','min:0'],
        'category_id' => ['required','exists:categories,id'],
    ]);

    \$product = Product::create(\$data);

    return redirect()
        ->route('products.show', \$product)
        ->with('status', 'Product created!');
}", 'php'));

    $p[] = $T::slide(12, $total, 'Authentication with Breeze',
        $T::codeBlock(
"# Install auth in one command
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
php artisan migrate

# You now have: /register, /login, /forgot-password,
# /reset-password, /verify-email, password confirmation, sessions, CSRF", 'bash'));

    $p[] = $T::slide(13, $total, 'Authorization — Policies',
        $T::codeBlock(
"// app/Policies/ProductPolicy.php
public function update(User \$user, Product \$product): bool {
    return \$user->id === \$product->user_id || \$user->is_admin;
}

// Usage in controller
\$this->authorize('update', \$product);

// In Blade
@can('update', \$product)
  <a href=\"{{ route('products.edit', \$product) }}\">Edit</a>
@endcan", 'php'));

    $p[] = $T::slide(14, $total, 'Building A REST API',
        $T::codeBlock(
"// routes/api.php
use App\\Http\\Controllers\\Api\\ProductApiController;

Route::apiResource('products', ProductApiController::class);

// Controller
public function index(): JsonResponse {
    return response()->json(Product::paginate(20));
}
public function store(StoreProductRequest \$req): JsonResponse {
    return response()->json(Product::create(\$req->validated()), 201);
}

// Consumers call
// GET  /api/products
// POST /api/products  (JSON body)
// GET  /api/products/1
// PUT  /api/products/1
// DELETE /api/products/1", 'php'));

    $p[] = $T::slide(15, $total, 'API Resources — Clean JSON',
        $T::codeBlock(
"// app/Http/Resources/ProductResource.php
public function toArray(\$request): array {
    return [
        'id'      => \$this->id,
        'name'    => \$this->name,
        'slug'    => \$this->slug,
        'price'   => number_format(\$this->price_cents / 100, 2),
        'in_stock'=> \$this->stock > 0,
        'category'=> CategoryResource::make(\$this->whenLoaded('category')),
    ];
}

// Usage
return ProductResource::collection(Product::with('category')->paginate(20));", 'php'));

    $p[] = $T::slide(16, $total, 'Queues & Jobs',
        $T::codeBlock(
"# Generate a job
php artisan make:job SendOrderConfirmation

# In the job
public function handle(MailService \$mail): void {
    \$mail->send(\$this->order->customer_email, new OrderShipped(\$this->order));
}

# Dispatch
SendOrderConfirmation::dispatch(\$order);

# Start the worker
php artisan queue:work --queue=default", 'bash'));

    $p[] = $T::slide(17, $total, 'Caching',
        $T::codeBlock(
"// Remember forever
\$top = Cache::rememberForever('top-products', function () {
    return Product::orderByDesc('sales')->limit(10)->get();
});

// TTL remember (60 seconds)
\$hot = Cache::remember('hot', 60, fn() => Product::latest()->limit(5)->get());

// Manual
Cache::put('key', 'value', 3600);
Cache::forget('key');", 'php'));

    $p[] = $T::slide(18, $total, 'Middleware',
        $T::codeBlock(
"// app/Http/Middleware/LogRequest.php
public function handle(Request \$request, Closure \$next): Response {
    Log::info(\$request->method() . ' ' . \$request->path());
    return \$next(\$request);
}

// Register in bootstrap/app.php (Laravel 11)
->withMiddleware(function (Middleware \$m) {
    \$m->append(LogRequest::class);
})

// Route-level
Route::get('/admin', AdminDashboard::class)->middleware(['auth', 'can:admin']);", 'php'));

    $p[] = $T::slide(19, $total, 'Testing With PHPUnit',
        $T::codeBlock(
"// tests/Feature/ProductTest.php
public function test_user_can_view_products_list(): void {
    Product::factory(3)->create();
    \$response = \$this->get('/products');
    \$response->assertStatus(200)->assertSeeText('Products');
}

public function test_guest_cannot_create_product(): void {
    \$response = \$this->post('/products', ['name' => 'X']);
    \$response->assertRedirect('/login');
}

// Run: php artisan test", 'php'));

    $p[] = $T::slide(20, $total, 'AI With Laravel — Prompt Patterns',
        $T::codeBlock(
"Generate a Laravel 11 feature:
 - Model Product + migration with columns: name, slug, price_cents, stock, description
 - Controller with resource methods + StoreProductRequest & UpdateProductRequest
 - Policy: only owner or admin can edit/delete
 - Blade index page with pagination + Tailwind styling
 - Factory & seeder with 50 fake products

Output each file separately with its path comment at the top.", 'prompt'));

    $p[] = $T::slide(21, $total, 'Key Takeaways', $T::bulletList([
        'Laravel = Artisan + Eloquent + Blade + conventions',
        'Migrations + Factories + Seeders replicate your DB anywhere',
        'Breeze gives full auth in one command',
        'Policies handle authorization cleanly',
        'API Resources + apiResource routes = instant JSON API',
    ]), 'sba-recap');

    $p[] = $T::slide(22, $total, 'Up Next — Lesson 14',
        $T::lead('Framework mastered. Next we build a real e-commerce store end to end: <b>Project #1 — Complete Laravel E-commerce</b>.'));

    return $T::deckOpen() . implode("\n", $p) . $T::deckClose();
}

function lesson_14_content(): string {
    $T = 'SlideTemplate'; $total = 22;
    $p = [];
    $p[] = $T::cover(14, 24,
        'Project #1 — Build a Complete Laravel E-commerce Store',
        'Zero to launched: a full Laravel 11 e-commerce site with authentication, product catalog, cart, checkout, Stripe payment, order emails, admin panel, and tests.',
        'Module 3', '6h');

    $p[] = $T::slide(2, $total, 'Feature Scope',
        $T::cardGrid([
            ['icon' => '🛍️', 'title' => 'Storefront', 'text' => 'Browse, filter, search; responsive with Tailwind'],
            ['icon' => '🛒', 'title' => 'Cart', 'text' => 'Session-based with qty + coupons', 'color' => 'sba-pink'],
            ['icon' => '💳', 'title' => 'Checkout', 'text' => 'Stripe test-mode payments + guest checkout', 'color' => 'sba-cyan'],
            ['icon' => '📦', 'title' => 'Orders', 'text' => 'Confirmation emails, order history, statuses', 'color' => 'sba-green'],
            ['icon' => '⚙️', 'title' => 'Admin', 'text' => 'CRUD products, categories, orders; charts'],
            ['icon' => '🧪', 'title' => 'Tests', 'text' => '40+ feature tests covering every user flow', 'color' => 'sba-pink'],
        ], 3));

    $p[] = $T::slide(3, $total, 'Project Bootstrap',
        $T::codeBlock(
"laravel new swiss-shop
cd swiss-shop
composer require laravel/breeze --dev
php artisan breeze:install blade --dark
composer require stripe/stripe-php
composer require barryvdh/laravel-dompdf
npm install
cp .env.example .env
php artisan key:generate", 'bash'));

    $p[] = $T::slide(4, $total, 'Domain Models',
        $T::codeBlock(
"php artisan make:model Category       -mfs
php artisan make:model Product        -mfs
php artisan make:model Address        -mf
php artisan make:model Cart           -m
php artisan make:model CartItem       -m
php artisan make:model Coupon         -mf
php artisan make:model Order          -mfs
php artisan make:model OrderItem      -m
php artisan make:model Review         -mf
php artisan migrate:fresh --seed", 'bash') .
        $T::callout('info', 'Flags', '<code class="sba-inline">-m</code> = migration, <code class="sba-inline">-f</code> = factory, <code class="sba-inline">-s</code> = seeder, <code class="sba-inline">-c</code> = controller.'));

    $p[] = $T::slide(5, $total, 'Product Model & Relations',
        $T::codeBlock(
"class Product extends Model {
    protected \$fillable = ['name','slug','sku','price_cents','stock','category_id','description','image'];
    protected \$casts    = ['price_cents' => 'int'];

    public function category() { return \$this->belongsTo(Category::class); }
    public function reviews()  { return \$this->hasMany(Review::class);      }

    public function getPriceAttribute() {
        return number_format(\$this->price_cents / 100, 2);
    }
    public function scopeInStock(\$q)   { return \$q->where('stock','>',0); }
    public function scopeFeatured(\$q)  { return \$q->where('is_featured',true); }
}", 'php'));

    $p[] = $T::slide(6, $total, 'Cart Service (Session-based)',
        $T::codeBlock(
"class CartService {
    public function add(Product \$p, int \$qty = 1): void {
        \$cart = session()->get('cart', []);
        \$cart[\$p->id] = (\$cart[\$p->id] ?? 0) + \$qty;
        session()->put('cart', \$cart);
    }
    public function lines(): Collection {
        \$cart = session('cart', []);
        return Product::findMany(array_keys(\$cart))
            ->map(fn(\$p) => [ 'product'=>\$p, 'qty'=>\$cart[\$p->id] ]);
    }
    public function total(): int {
        return \$this->lines()->sum(fn(\$l) => \$l['product']->price_cents * \$l['qty']);
    }
    public function clear(): void { session()->forget('cart'); }
}", 'php'));

    $p[] = $T::slide(7, $total, 'Storefront Routes',
        $T::codeBlock(
"Route::get('/',                       [StoreController::class,'home'])->name('home');
Route::get('/products',               [StoreController::class,'index'])->name('products.index');
Route::get('/products/{product:slug}',[StoreController::class,'show'])->name('products.show');

Route::post('/cart/add/{product}',    [CartController::class,'add'])->name('cart.add');
Route::patch('/cart/set/{product}',   [CartController::class,'set'])->name('cart.set');
Route::delete('/cart/remove/{product}',[CartController::class,'remove'])->name('cart.remove');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class,'show'])->name('checkout');
    Route::post('/checkout',[CheckoutController::class,'place'])->name('checkout.place');
    Route::get('/orders',   [OrderController::class,'index'])->name('orders.index');
});", 'php'));

    $p[] = $T::slide(8, $total, 'Stripe Checkout Integration',
        $T::codeBlock(
"// .env
STRIPE_KEY=pk_test_…
STRIPE_SECRET=sk_test_…

// CheckoutController
public function place(Request \$req, CartService \$cart) {
    \\Stripe\\Stripe::setApiKey(config('services.stripe.secret'));

    \$session = \\Stripe\\Checkout\\Session::create([
      'line_items' => \$cart->lines()->map(fn(\$l) => [
          'price_data' => [
              'currency'     => 'usd',
              'product_data' => ['name' => \$l['product']->name],
              'unit_amount'  => \$l['product']->price_cents,
          ],
          'quantity' => \$l['qty'],
      ])->toArray(),
      'mode'       => 'payment',
      'success_url'=> route('checkout.success') . '?s={CHECKOUT_SESSION_ID}',
      'cancel_url' => route('products.index'),
    ]);
    return redirect(\$session->url);
}", 'php'));

    $p[] = $T::slide(9, $total, 'Order Creation & Emails',
        $T::codeBlock(
"// On success webhook or success_url
public function success(Request \$req, CartService \$cart) {
    DB::transaction(function () use (\$req, \$cart) {
        \$order = Order::create([
            'user_id'     => auth()->id(),
            'total_cents' => \$cart->total(),
            'status'      => 'paid',
        ]);
        \$cart->lines()->each(function (\$l) use (\$order) {
            OrderItem::create([
                'order_id'         => \$order->id,
                'product_id'       => \$l['product']->id,
                'qty'              => \$l['qty'],
                'unit_price_cents' => \$l['product']->price_cents,
            ]);
            \$l['product']->decrement('stock', \$l['qty']);
        });
        Mail::to(auth()->user())->send(new OrderConfirmed(\$order));
        \$cart->clear();
    });
    return redirect()->route('orders.index')->with('status','Paid!');
}", 'php'));

    $p[] = $T::slide(10, $total, 'Admin Panel with Filament (v3)',
        $T::codeBlock(
"composer require filament/filament
php artisan filament:install --panels
php artisan make:filament-user

php artisan make:filament-resource Product --generate
php artisan make:filament-resource Order --generate

# Visit /admin → polished CRUD for every model", 'bash') .
        $T::callout('success', 'Filament', 'Filament generates admin UIs with charts, relation managers, bulk actions — saves weeks of work.'));

    $p[] = $T::slide(11, $total, 'Coupons & Discounts',
        $T::codeBlock(
"class Coupon extends Model {
    public function isValid(): bool {
        return \$this->active
            && \$this->uses < \$this->max_uses
            && now()->between(\$this->starts_at, \$this->ends_at);
    }
    public function applyTo(int \$subtotalCents): int {
        return match (\$this->type) {
            'percent' => intval(\$subtotalCents * (1 - \$this->value / 100)),
            'fixed'   => max(0, \$subtotalCents - \$this->value),
        };
    }
}", 'php'));

    $p[] = $T::slide(12, $total, 'Search with Laravel Scout + Meilisearch',
        $T::codeBlock(
"composer require laravel/scout meilisearch/meilisearch-php
php artisan vendor:publish --provider=\"Laravel\\Scout\\ScoutServiceProvider\"

// Product model
use Laravel\\Scout\\Searchable;
class Product extends Model {
    use Searchable;
    public function toSearchableArray(): array {
        return ['id'=>\$this->id, 'name'=>\$this->name, 'description'=>\$this->description];
    }
}

// Route
Route::get('/search', fn(Request \$r) =>
    Product::search(\$r->q)->paginate(20));", 'php'));

    $p[] = $T::slide(13, $total, 'SEO & Metadata',
        $T::codeBlock(
"{{-- resources/views/products/show.blade.php --}}
@push('meta')
  <title>{{ \$product->name }} – SwissShop</title>
  <meta name=\"description\" content=\"{{ Str::limit(\$product->description, 160) }}\">
  <meta property=\"og:title\"      content=\"{{ \$product->name }}\">
  <meta property=\"og:image\"      content=\"{{ asset(\$product->image) }}\">
  <meta property=\"og:type\"       content=\"product\">
  <link rel=\"canonical\"          href=\"{{ url()->current() }}\">
@endpush", 'php'));

    $p[] = $T::slide(14, $total, 'PDF Invoices',
        $T::codeBlock(
"// OrderController.php
public function invoice(Order \$order): Response {
    \$this->authorize('view', \$order);
    \$pdf = Pdf::loadView('orders.invoice', ['order' => \$order]);
    return \$pdf->download(\"invoice-{\$order->id}.pdf\");
}", 'php') .
        $T::paragraph('Uses barryvdh/laravel-dompdf — one-liner PDFs from a Blade view.'));

    $p[] = $T::slide(15, $total, 'Performance Tips',
        $T::bulletList([
            'Eager-load related models with <code class="sba-inline">with()</code> to avoid N+1 queries',
            'Cache expensive queries: <code class="sba-inline">Cache::remember(\'top\', 3600, fn() =&gt; …)</code>',
            'Laravel Telescope to profile queries locally',
            '<code class="sba-inline">php artisan optimize</code> for production',
            'Use Octane + Swoole/FrankenPHP for 10x throughput',
        ]));

    $p[] = $T::slide(16, $total, 'Security Checklist',
        $T::bulletList([
            'Never dump <code class="sba-inline">.env</code>; it\'s in <code class="sba-inline">.gitignore</code>',
            'Always CSRF-protect forms (Blade <code class="sba-inline">@csrf</code>)',
            'Escape output with <code class="sba-inline">{{ \$var }}</code>, not <code class="sba-inline">{!! \$var !!}</code>',
            'Validate everything in FormRequests',
            'Use policies or gates for authorization',
            'Rotate <code class="sba-inline">APP_KEY</code> and Stripe keys if leaked',
        ]));

    $p[] = $T::slide(17, $total, 'Feature Tests',
        $T::codeBlock(
"test('guest can browse products', function () {
    Product::factory(5)->create();
    \$this->get('/products')->assertOk()->assertSeeText('Products');
});

test('user can add item to cart', function () {
    \$user    = User::factory()->create();
    \$product = Product::factory()->create();
    \$this->actingAs(\$user)
         ->post(route('cart.add', \$product))
         ->assertRedirect();
    expect(session('cart'))->toBe([\$product->id => 1]);
});", 'php'));

    $p[] = $T::slide(18, $total, 'AI Acceleration In This Project',
        $T::bulletList([
            '"Write an <b>OrderPolicy</b> where only the owner and admins can view an order"',
            '"Generate <b>Filament resource</b> for Product with filters on category and stock"',
            '"Convert the cart service to use <b>the database instead of sessions</b> for logged-in users"',
            '"Add a <b>Stripe webhook</b> that marks orders as paid when <code class="sba-inline">checkout.session.completed</code> fires"',
            '"Write a <b>Pest feature test</b> that covers the full checkout flow with a fake Stripe"',
        ]));

    $p[] = $T::slide(19, $total, 'Final Folder Layout',
        $T::codeBlock(
"app/
├── Http/Controllers/Store/
│   ├── StoreController.php
│   ├── CartController.php
│   ├── CheckoutController.php
│   └── OrderController.php
├── Http/Controllers/Admin/
├── Filament/Resources/
├── Models/  Cart, CartItem, Coupon, Order, OrderItem, Product, Review
├── Services/CartService.php, StripeService.php
├── Mail/OrderConfirmed.php
resources/views/
├── layouts/app.blade.php
├── store/  home, products/index, products/show, cart, checkout
└── emails/order-confirmed.blade.php", 'text'));

    $p[] = $T::slide(20, $total, 'Your Homework — Ship Project #1',
        $T::numberedList([
            'Commit the repo on GitHub',
            'Record a 2-minute demo video',
            'Write a README with screenshots and setup steps',
            'Stretch: add a wishlist feature',
            'Stretch: add product variants (size/color)',
        ]));

    $p[] = $T::slide(21, $total, 'Key Takeaways', $T::bulletList([
        'Laravel + Filament + Stripe ships a real store in days',
        'Session carts → DB carts when the user logs in',
        'Always wrap multi-step writes in a DB transaction',
        'Eager-load to avoid the N+1 query trap',
        'Test the critical flows before every merge',
    ]), 'sba-recap');

    $p[] = $T::slide(22, $total, 'Up Next — Lesson 15',
        $T::lead('Project #1 shipped! Now we rebuild the same store with a completely different stack: <b>Node + Express + TypeScript</b>.'));

    return $T::deckOpen() . implode("\n", $p) . $T::deckClose();
}
