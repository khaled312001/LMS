<?php
require_once __DIR__ . '/slide_template.php';

/**
 * Lessons 15-20 — MERN stack + WordPress.
 */

function lesson_15_content(): string {
    $T = 'SlideTemplate'; $total = 21;
    $p = [];
    $p[] = $T::cover(15, 24,
        'Node.js & Express — Building REST APIs with TypeScript',
        'Leave PHP behind; enter the JavaScript-everywhere stack. Build a type-safe, fast, modern REST API with Node 22, Express 5, TypeScript, and Zod.',
        'Module 4', '4h');

    $p[] = $T::slide(2, $total, 'Objectives', $T::bulletList([
        'Scaffold a TypeScript-first Node project',
        'Design REST endpoints with Express 5',
        'Validate inputs with Zod',
        'Handle errors consistently',
        'Structure for testability',
        'Ship a dev-ready API in < 2 hours',
    ]));

    $p[] = $T::slide(3, $total, 'Bootstrap The Project',
        $T::codeBlock(
"mkdir shop-api && cd shop-api
npm init -y
npm i express zod dotenv cors helmet morgan
npm i -D typescript ts-node-dev @types/node @types/express @types/cors @types/morgan

# tsconfig
npx tsc --init --rootDir src --outDir dist --target es2022 \\
  --module node16 --moduleResolution node16 --esModuleInterop --strict", 'bash'));

    $p[] = $T::slide(4, $total, 'Minimum Viable Server (src/server.ts)',
        $T::codeBlock(
"import 'dotenv/config';
import express from 'express';
import cors from 'cors';
import helmet from 'helmet';
import morgan from 'morgan';

const app = express();
app.use(helmet());
app.use(cors());
app.use(morgan('tiny'));
app.use(express.json());

app.get('/health', (_, res) => res.json({ ok: true }));

const port = Number(process.env.PORT) || 3000;
app.listen(port, () => console.log(`API on :\${port}`));", 'typescript') .
        $T::codeBlock("# run
npx ts-node-dev src/server.ts

# test
curl http://localhost:3000/health", 'bash'));

    $p[] = $T::slide(5, $total, 'Project Layout',
        $T::codeBlock(
"src/
├── server.ts             # entry
├── app.ts                # express app (testable)
├── config/env.ts
├── routes/
│   ├── index.ts
│   ├── products.route.ts
│   └── auth.route.ts
├── controllers/
│   ├── products.controller.ts
│   └── auth.controller.ts
├── services/
├── middlewares/
│   ├── error.ts
│   ├── validate.ts
│   └── auth.ts
├── schemas/              # Zod
└── types/", 'text'));

    $p[] = $T::slide(6, $total, 'Routing with Express 5',
        $T::codeBlock(
"// routes/products.route.ts
import { Router } from 'express';
import { list, show, create, update, remove } from '../controllers/products.controller';
import { requireAuth }  from '../middlewares/auth';
import { validate }     from '../middlewares/validate';
import { productSchema } from '../schemas/product.schema';

const r = Router();
r.get('/',            list);
r.get('/:id',         show);
r.post('/',           requireAuth, validate(productSchema), create);
r.put('/:id',         requireAuth, validate(productSchema), update);
r.delete('/:id',      requireAuth, remove);
export default r;", 'typescript'));

    $p[] = $T::slide(7, $total, 'Controllers',
        $T::codeBlock(
"// controllers/products.controller.ts
import { Request, Response, NextFunction } from 'express';
import * as svc from '../services/product.service';

export const list = async (req: Request, res: Response, next: NextFunction) => {
  try { res.json(await svc.list()); }
  catch (e) { next(e); }
};

export const show = async (req: Request, res: Response, next: NextFunction) => {
  try {
    const p = await svc.find(req.params.id);
    if (!p) return res.status(404).json({ error: 'Not found' });
    res.json(p);
  } catch (e) { next(e); }
};", 'typescript'));

    $p[] = $T::slide(8, $total, 'Zod Input Validation',
        $T::codeBlock(
"// schemas/product.schema.ts
import { z } from 'zod';

export const productSchema = z.object({
  name:        z.string().min(2).max(120),
  price_cents: z.number().int().positive(),
  stock:       z.number().int().min(0).default(0),
  category_id: z.string().uuid(),
});
export type ProductInput = z.infer<typeof productSchema>;

// middlewares/validate.ts
export const validate = (schema: z.ZodTypeAny) =>
  (req: Request, res: Response, next: NextFunction) => {
    const result = schema.safeParse(req.body);
    if (!result.success)
      return res.status(400).json({ error: result.error.issues });
    req.body = result.data;
    next();
  };", 'typescript'));

    $p[] = $T::slide(9, $total, 'Error Handling Middleware',
        $T::codeBlock(
"// middlewares/error.ts
import { Request, Response, NextFunction } from 'express';

export class HttpError extends Error {
  constructor(public status: number, message: string) { super(message); }
}

export function errorHandler(
  err: Error, _req: Request, res: Response, _next: NextFunction
) {
  if (err instanceof HttpError)
    return res.status(err.status).json({ error: err.message });
  console.error(err);
  res.status(500).json({ error: 'Internal server error' });
}

// Mount LAST in app.ts
app.use(errorHandler);", 'typescript'));

    $p[] = $T::slide(10, $total, 'Testing With Vitest + Supertest',
        $T::codeBlock(
"npm i -D vitest supertest @types/supertest

// tests/products.test.ts
import { describe, it, expect } from 'vitest';
import request from 'supertest';
import { app } from '../src/app';

describe('GET /products', () => {
  it('returns 200 and an array', async () => {
    const res = await request(app).get('/products');
    expect(res.status).toBe(200);
    expect(Array.isArray(res.body)).toBe(true);
  });
});", 'typescript'));

    $p[] = $T::slide(11, $total, 'Logging With pino',
        $T::codeBlock(
"npm i pino pino-http

// app.ts
import pinoHttp from 'pino-http';
app.use(pinoHttp({
  level: process.env.LOG_LEVEL ?? 'info',
  redact: ['req.headers.authorization'],
}));

// in a controller
req.log.info({ userId: req.user?.id }, 'creating product');", 'typescript'));

    $p[] = $T::slide(12, $total, 'Rate-limiting',
        $T::codeBlock(
"import rateLimit from 'express-rate-limit';

app.use('/auth/login', rateLimit({
  windowMs: 15 * 60 * 1000,
  limit:    5,
  message:  'Too many attempts, try later',
}));

app.use('/', rateLimit({ windowMs: 60_000, limit: 120 }));", 'typescript'));

    $p[] = $T::slide(13, $total, 'Configuration With dotenv + Zod',
        $T::codeBlock(
"// config/env.ts
import { z } from 'zod';

const env = z.object({
  NODE_ENV:   z.enum(['development','test','production']).default('development'),
  PORT:       z.coerce.number().default(3000),
  MONGO_URL:  z.string().url(),
  JWT_SECRET: z.string().min(32),
}).parse(process.env);

export default env;", 'typescript'));

    $p[] = $T::slide(14, $total, 'Streaming & File Upload',
        $T::codeBlock(
"import multer from 'multer';
const upload = multer({ dest: 'uploads/', limits: { fileSize: 5_000_000 } });

app.post('/products/:id/image',
  requireAuth,
  upload.single('image'),
  async (req, res) => {
    if (!req.file) return res.status(400).json({ error: 'no file' });
    const url = await s3Upload(req.file);
    res.json({ url });
});", 'typescript'));

    $p[] = $T::slide(15, $total, 'AI Prompt For A New Endpoint',
        $T::codeBlock(
"Add a POST /orders endpoint:
 - Requires Bearer JWT
 - Body: { items: [{ product_id, qty }], address_id }
 - Validate with Zod
 - Service: create order + order_items in a MongoDB transaction,
   decrement product stock
 - Response: 201 Created + the full order JSON
 - Unit test in Vitest covering happy path, 422 on invalid,
   401 without token, 409 on out-of-stock

Output: route file, controller file, service file, schema file,
and tests. Include path comments.", 'prompt'));

    $p[] = $T::slide(16, $total, 'Production Packaging',
        $T::codeBlock(
"# Dockerfile
FROM node:22-alpine AS build
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npx tsc

FROM node:22-alpine
WORKDIR /app
COPY --from=build /app/dist ./dist
COPY --from=build /app/node_modules ./node_modules
CMD [\"node\",\"dist/server.js\"]", 'dockerfile'));

    $p[] = $T::slide(17, $total, 'Useful Middlewares In The Ecosystem',
        $T::table(['Package', 'Purpose'], [
            ['helmet', 'Security headers'],
            ['cors', 'CORS'],
            ['compression', 'gzip responses'],
            ['cookie-parser', 'Parse cookies'],
            ['csurf', 'CSRF tokens (SSR apps)'],
            ['express-validator', 'Alternative to Zod'],
            ['passport', 'Auth strategies (OAuth, etc.)'],
        ]));

    $p[] = $T::slide(18, $total, 'Common Pitfalls',
        $T::bulletList([
            'Awaiting a <code class="sba-inline">res.send</code> (it\'s not async — use <code class="sba-inline">return res.json(...)</code>)',
            'Forgetting <code class="sba-inline">next(err)</code> in async try/catch',
            'Not mounting errorHandler <i>last</i>',
            'Relying on <code class="sba-inline">req.body</code> being present without <code class="sba-inline">express.json()</code>',
            'Logging secrets (always redact)',
        ]));

    $p[] = $T::slide(19, $total, 'Performance Tips',
        $T::bulletList([
            'Enable compression',
            'Use streaming responses for big payloads',
            'Use worker threads for CPU-heavy tasks',
            'Replace Express with <b>Hono</b> or <b>Fastify</b> if you need more speed',
            'PM2 or systemd to run in production with auto-restarts',
        ]));

    $p[] = $T::slide(20, $total, 'Key Takeaways', $T::bulletList([
        'Express 5 + TypeScript + Zod is a joyful stack',
        'Keep controllers thin; put logic in services',
        'Validate every input, redact every log',
        'Error handler middleware must be LAST',
        'Tests with Supertest cover real HTTP paths',
    ]), 'sba-recap');

    $p[] = $T::slide(21, $total, 'Up Next — Lesson 16',
        $T::lead('API endpoints ready. Now we pair them with a flexible data layer: <b>MongoDB & Mongoose</b>.'));

    return $T::deckOpen() . implode("\n", $p) . $T::deckClose();
}

function lesson_16_content(): string {
    $T = 'SlideTemplate'; $total = 20;
    $p = [];
    $p[] = $T::cover(16, 24,
        'MongoDB & Mongoose — Schema Design for E-commerce',
        'Relational DBs model rows; MongoDB models documents. Learn when to pick Mongo, how to design schemas, and how to query with Mongoose in a type-safe way.',
        'Module 4', '4h');

    $p[] = $T::slide(2, $total, 'When Mongo vs When MySQL',
        $T::table(['Use Mongo when', 'Use MySQL when'], [
            ['Flexible or evolving schema', 'Schema is stable & known'],
            ['High read throughput with denormalised docs', 'Heavy joins / reporting'],
            ['Geospatial, analytics, logs', 'Financial / transactional'],
            ['Rapid prototyping', 'Regulatory compliance'],
            ['Nested data (product → variants → images)', 'Flat relational data'],
        ]));

    $p[] = $T::slide(3, $total, 'Setup (Atlas Free Tier)',
        $T::numberedList([
            'Create a free account at <code class="sba-inline">cloud.mongodb.com</code>',
            'Create a free M0 cluster',
            'Create a DB user + whitelist your IP',
            'Copy the connection string to <code class="sba-inline">.env</code>',
            'Install drivers: <code class="sba-inline">npm i mongoose</code>',
        ]));

    $p[] = $T::slide(4, $total, 'Connecting With Mongoose',
        $T::codeBlock(
"// db.ts
import mongoose from 'mongoose';
import env from './config/env';

export async function connect() {
  mongoose.set('strictQuery', true);
  await mongoose.connect(env.MONGO_URL);
  console.log('Mongo connected');
}
process.on('SIGINT', () => mongoose.disconnect());", 'typescript'));

    $p[] = $T::slide(5, $total, 'First Schema & Model',
        $T::codeBlock(
"// models/product.model.ts
import { Schema, model, Types } from 'mongoose';

const productSchema = new Schema({
  name:        { type: String, required: true, trim: true },
  slug:        { type: String, required: true, unique: true, index: true },
  priceCents:  { type: Number, required: true, min: 1 },
  stock:       { type: Number, default: 0 },
  categoryId:  { type: Types.ObjectId, ref: 'Category', required: true, index: true },
  images:      [String],
  attributes:  { type: Map, of: String },          // flexible key/val
}, { timestamps: true });

export const Product = model('Product', productSchema);", 'typescript'));

    $p[] = $T::slide(6, $total, 'Embedded vs Referenced',
        $T::codeBlock(
"// Referenced (normalised)
{
  _id: 'order-1',
  userId: ObjectId('user-1'),
  items: [
    { productId: ObjectId('p-1'), qty: 2 },
    { productId: ObjectId('p-2'), qty: 1 }
  ]
}

// Embedded (denormalised — read-optimised)
{
  _id: 'order-1',
  user: { id: 'user-1', name: 'Alice' },
  items: [
    { productId: 'p-1', name: 'Watch', priceCents: 19900, qty: 2 },
    { productId: 'p-2', name: 'Band',  priceCents:  1900, qty: 1 }
  ]
}", 'javascript') .
        $T::callout('success', 'Rule of thumb',
            'Embed for data that is always accessed together (order → items). Reference when data is shared (products in many orders).'));

    $p[] = $T::slide(7, $total, 'CRUD With Mongoose',
        $T::codeBlock(
"// Create
await Product.create({ name, slug, priceCents, categoryId });

// Read
const list = await Product.find({ stock: { \$gt: 0 } }).limit(20).sort('-createdAt');
const one  = await Product.findById(id).populate('categoryId');

// Update
await Product.updateOne({ slug }, { \$inc: { stock: -1 } });

// Delete
await Product.findByIdAndDelete(id);", 'typescript'));

    $p[] = $T::slide(8, $total, 'Queries & Operators',
        $T::table(['Operator', 'Meaning'], [
            ['<code class="sba-inline">$eq, $ne</code>', 'Equal, not equal'],
            ['<code class="sba-inline">$gt, $gte, $lt, $lte</code>', 'Comparison'],
            ['<code class="sba-inline">$in, $nin</code>', 'In / not in array'],
            ['<code class="sba-inline">$and, $or, $not</code>', 'Logical'],
            ['<code class="sba-inline">$regex</code>', 'Regex match'],
            ['<code class="sba-inline">$text</code>', 'Full-text search (with index)'],
            ['<code class="sba-inline">$near</code>', 'Geospatial proximity'],
        ]));

    $p[] = $T::slide(9, $total, 'Aggregation Pipeline',
        $T::codeBlock(
"// Revenue per category this month
const pipeline = [
  { \$match: { placedAt: { \$gte: startOfMonth } } },
  { \$unwind: '\$items' },
  { \$group: {
      _id: '\$items.categoryId',
      revenue: { \$sum: { \$multiply: ['\$items.priceCents','\$items.qty'] } }
  }},
  { \$lookup: { from: 'categories', localField: '_id', foreignField: '_id', as: 'cat' } },
  { \$sort: { revenue: -1 } }
];
const rows = await Order.aggregate(pipeline);", 'typescript'));

    $p[] = $T::slide(10, $total, 'Indexes',
        $T::codeBlock(
"// In schema
productSchema.index({ slug: 1 }, { unique: true });
productSchema.index({ name: 'text', description: 'text' });
productSchema.index({ priceCents: 1 });
productSchema.index({ categoryId: 1, priceCents: 1 });  // compound

// Run once to create
await Product.syncIndexes();", 'typescript'));

    $p[] = $T::slide(11, $total, 'Transactions',
        $T::codeBlock(
"const session = await mongoose.startSession();
session.startTransaction();
try {
  const order = await Order.create([...], { session });
  await Product.updateOne(
    { _id: productId, stock: { \$gte: qty } },
    { \$inc: { stock: -qty } },
    { session }
  );
  await session.commitTransaction();
} catch (e) {
  await session.abortTransaction();
  throw e;
} finally {
  session.endSession();
}", 'typescript'));

    $p[] = $T::slide(12, $total, 'Validation At Two Layers',
        $T::codeBlock(
"// 1) Zod at the API edge
const body = productSchema.parse(req.body);

// 2) Mongoose schema in the DB
// Mongoose re-enforces types, min/max, custom validators,
// and unique constraints.", 'typescript') .
        $T::callout('info', 'Why both?',
            'Zod protects against malformed API input. Mongoose protects the data store against bugs in your own code.'));

    $p[] = $T::slide(13, $total, 'Relations Via populate()',
        $T::codeBlock(
"const order = await Order
  .findById(id)
  .populate('userId',       'name email')
  .populate('items.productId', 'name priceCents');

console.log(order.userId.email);                  // fully typed
console.log(order.items[0].productId.name);", 'typescript'));

    $p[] = $T::slide(14, $total, 'Plugins & Utilities',
        $T::bulletList([
            'mongoose-paginate-v2 — easy pagination',
            'mongoose-lean-virtuals — use virtuals in lean queries',
            '@casl/ability — access control',
            'mongoose-slug-generator — auto-slugs',
            'mongoose-autopopulate — auto-populate relations',
        ]));

    $p[] = $T::slide(15, $total, 'Seeding Data',
        $T::codeBlock(
"// scripts/seed.ts
import { connect } from '../src/db';
import { Product } from '../src/models/product.model';
import { faker } from '@faker-js/faker';

await connect();
await Product.deleteMany({});
const docs = Array.from({ length: 100 }, () => ({
  name:       faker.commerce.productName(),
  slug:       faker.helpers.slugify(faker.commerce.productName()).toLowerCase() + '-' + faker.string.nanoid(6),
  priceCents: faker.number.int({ min: 1000, max: 50000 }),
  stock:      faker.number.int({ min: 0, max: 200 }),
  categoryId: new mongoose.Types.ObjectId(),
}));
await Product.insertMany(docs);
console.log('seeded');", 'typescript'));

    $p[] = $T::slide(16, $total, 'Security',
        $T::bulletList([
            'Limit DB user privileges to the one app database',
            'Enable IP allow-lists on Atlas',
            'Never interpolate user input into <code class="sba-inline">$where</code>',
            'Prevent NoSQL injection: strip <code class="sba-inline">$</code> keys from req.body',
            'Rotate credentials if a secret leaks',
        ]));

    $p[] = $T::slide(17, $total, 'Backup & Restore',
        $T::codeBlock(
"# Dump a database
mongodump --uri=\"mongodb+srv://...\" --out=./dump

# Restore
mongorestore --uri=\"mongodb+srv://...\" ./dump

# Export one collection to JSON
mongoexport --uri=\"...\" --collection=products --out=products.json", 'bash'));

    $p[] = $T::slide(18, $total, 'AI Prompt Patterns For Mongo',
        $T::codeBlock(
"Design a Mongoose schema for a Shopify-like product catalog:
 - Products with variants (size, color, sku, stock, price)
 - Categories (hierarchical) referenced by ObjectId
 - Tags array of strings
 - Media array of objects { url, alt, position }
 - Reviews embedded (up to 20), with ref to full reviews in separate coll.
 - Timestamps, slug unique index, text index on name/description.
Return: a TypeScript file with the schema and Model<Product> type.", 'prompt'));

    $p[] = $T::slide(19, $total, 'Key Takeaways', $T::bulletList([
        'Mongo models documents, not rows — embed when read-together',
        'Always index FKs and query filters',
        'Use transactions for atomic multi-doc writes',
        'Validate at both the API edge and the schema',
        'Mongoose populate gives you relational-style reads',
    ]), 'sba-recap');

    $p[] = $T::slide(20, $total, 'Up Next — Lesson 17',
        $T::lead('Data + API ready. Now we secure it: <b>JWT Authentication, Middleware & Secure REST Patterns</b>.'));

    return $T::deckOpen() . implode("\n", $p) . $T::deckClose();
}

function lesson_17_content(): string {
    $T = 'SlideTemplate'; $total = 21;
    $p = [];
    $p[] = $T::cover(17, 24,
        'JWT Authentication, Middleware & Secure REST Patterns',
        'Authentication is security-critical. Learn the right way to hash passwords, issue access + refresh JWTs, rotate tokens, and defend against the OWASP top 10 in your Node API.',
        'Module 4', '5h');

    $p[] = $T::slide(2, $total, 'Objectives', $T::bulletList([
        'Hash passwords with Argon2 / bcrypt properly',
        'Issue signed JWT access tokens + refresh tokens',
        'Rotate refresh tokens on every use',
        'Protect routes with middleware',
        'Implement logout, password reset, and email verification',
        'Store tokens securely in the browser (httpOnly cookies)',
    ]));

    $p[] = $T::slide(3, $total, 'Registration Endpoint',
        $T::codeBlock(
"import argon2 from 'argon2';
import { z } from 'zod';

const registerSchema = z.object({
  email:    z.string().email(),
  password: z.string().min(12),
  name:     z.string().min(2),
});

app.post('/auth/register', async (req, res, next) => {
  try {
    const data = registerSchema.parse(req.body);
    if (await User.findOne({ email: data.email }))
      return res.status(409).json({ error: 'email taken' });

    const passwordHash = await argon2.hash(data.password);
    const user = await User.create({ ...data, password: passwordHash });
    res.status(201).json({ id: user.id, email: user.email });
  } catch (e) { next(e); }
});", 'typescript'));

    $p[] = $T::slide(4, $total, 'Login & JWT',
        $T::codeBlock(
"import jwt from 'jsonwebtoken';

app.post('/auth/login', async (req, res) => {
  const { email, password } = req.body;
  const user = await User.findOne({ email });
  if (!user || !(await argon2.verify(user.password, password)))
    return res.status(401).json({ error: 'invalid credentials' });

  const access  = jwt.sign({ sub: user.id, role: user.role }, env.JWT_SECRET, { expiresIn: '15m' });
  const refresh = jwt.sign({ sub: user.id },                   env.JWT_REFRESH_SECRET, { expiresIn: '30d' });

  res.cookie('rt', refresh, { httpOnly: true, secure: true, sameSite: 'strict', path: '/auth' });
  res.json({ access });
});", 'typescript'));

    $p[] = $T::slide(5, $total, 'Auth Middleware',
        $T::codeBlock(
"export function requireAuth(req: Request, res: Response, next: NextFunction) {
  const header = req.headers.authorization;
  if (!header?.startsWith('Bearer '))
    return res.status(401).json({ error: 'missing token' });

  try {
    const payload = jwt.verify(header.slice(7), env.JWT_SECRET) as { sub: string; role: string };
    req.user = { id: payload.sub, role: payload.role };
    next();
  } catch {
    return res.status(401).json({ error: 'invalid token' });
  }
}

// Role-based
export const requireAdmin = (req, res, next) =>
  req.user?.role === 'admin' ? next() : res.status(403).end();", 'typescript'));

    $p[] = $T::slide(6, $total, 'Refresh Token Rotation',
        $T::codeBlock(
"// auth.route.ts
app.post('/auth/refresh', async (req, res) => {
  const token = req.cookies?.rt;
  if (!token) return res.status(401).end();

  try {
    const { sub } = jwt.verify(token, env.JWT_REFRESH_SECRET) as { sub: string };
    // Invalidate the used refresh token (DB allow-list)
    if (!(await RefreshToken.findOneAndDelete({ token })))
      return res.status(401).end();

    const user    = await User.findById(sub);
    const access  = jwt.sign({ sub: user.id, role: user.role }, env.JWT_SECRET, { expiresIn: '15m' });
    const refresh = jwt.sign({ sub: user.id }, env.JWT_REFRESH_SECRET, { expiresIn: '30d' });
    await RefreshToken.create({ userId: user.id, token: refresh });

    res.cookie('rt', refresh, { httpOnly: true, secure: true, sameSite: 'strict', path: '/auth' });
    res.json({ access });
  } catch { res.status(401).end(); }
});", 'typescript'));

    $p[] = $T::slide(7, $total, 'Password Hashing Rules',
        $T::bulletList([
            'Use <b>Argon2id</b> (best) or <b>bcrypt cost 12+</b>',
            'Never use MD5, SHA-1 or SHA-256 without HMAC',
            'Never store passwords in logs or error payloads',
            'Never return the hash in API responses',
            'Rate-limit login (5 attempts / 15 min per IP+email)',
        ]));

    $p[] = $T::slide(8, $total, 'Password Reset Flow',
        $T::numberedList([
            'User submits email on <code class="sba-inline">/forgot-password</code>',
            'Backend generates a random token (32 bytes), stores hashed version + 15-minute expiry',
            'Email a link: <code class="sba-inline">https://app/reset?token=RAW</code>',
            'User opens link → submits new password',
            'Backend verifies hash(token) + not expired → updates password + deletes token',
        ]));

    $p[] = $T::slide(9, $total, 'Email Verification',
        $T::codeBlock(
"// send a signed token
const token = jwt.sign({ sub: user.id }, env.EMAIL_SECRET, { expiresIn: '24h' });
await sendEmail(user.email, `Confirm: https://app/verify?t=\${token}`);

// verify endpoint
app.get('/verify', async (req, res) => {
  try {
    const { sub } = jwt.verify(req.query.t as string, env.EMAIL_SECRET);
    await User.updateOne({ _id: sub }, { emailVerified: true });
    res.redirect('/login?verified=1');
  } catch {
    res.status(400).send('Invalid or expired link');
  }
});", 'typescript'));

    $p[] = $T::slide(10, $total, 'Token Storage In The Browser',
        $T::table(['Storage', 'XSS risk', 'CSRF risk', 'Verdict'], [
            ['localStorage', '<b>HIGH</b>', 'Low', '❌ Avoid for tokens'],
            ['httpOnly cookie', 'Low', '<b>Medium</b> (mitigate with SameSite)', '✅ Preferred'],
            ['Memory (JS var)', 'Medium', 'Low', '✅ For access tokens'],
            ['Service worker cache', 'Medium', 'Low', '✅ Advanced option'],
        ]) .
        $T::callout('success', 'Best pattern',
            'Access token in memory; refresh token in an httpOnly Secure SameSite cookie.'));

    $p[] = $T::slide(11, $total, 'CSRF Protection',
        $T::codeBlock(
"// For cookie-based SPA calls
import csurf from 'csurf';
const csrf = csurf({ cookie: { httpOnly: true, secure: true, sameSite: 'strict' } });

app.get('/csrf', csrf, (req, res) => res.json({ token: req.csrfToken() }));
app.post('/*', csrf, /* your routes */);

// In React
fetch('/orders', { headers: { 'CSRF-Token': token } });", 'typescript'));

    $p[] = $T::slide(12, $total, 'OWASP Top 10 — The Most Important',
        $T::table(['Vulnerability', 'Mitigation'], [
            ['Injection', 'Parameterise every query, validate inputs'],
            ['Broken Auth', 'Strong hashing + token rotation + rate limits'],
            ['Broken Access Control', 'Check auth on every route; test with non-admin'],
            ['XSS', 'Escape output, use CSP, httpOnly cookies'],
            ['SSRF', 'Whitelist external URLs, reject localhost'],
            ['Insecure Deserialization', 'Never eval / load untrusted JSON schemas'],
        ]));

    $p[] = $T::slide(13, $total, 'Helmet — Secure Headers',
        $T::codeBlock(
"import helmet from 'helmet';

app.use(helmet({
  contentSecurityPolicy: {
    directives: {
      defaultSrc: [\"'self'\"],
      imgSrc:     [\"'self'\", 'data:', 'https:'],
      scriptSrc:  [\"'self'\"],
      styleSrc:   [\"'self'\", \"'unsafe-inline'\"],
    }
  },
  hsts: { maxAge: 31536000, includeSubDomains: true, preload: true },
}));", 'typescript'));

    $p[] = $T::slide(14, $total, 'Audit Logging',
        $T::codeBlock(
"// For high-value actions (password change, payout, account delete)
await AuditLog.create({
  userId:    req.user.id,
  action:    'password_changed',
  ip:        req.ip,
  userAgent: req.get('user-agent'),
  meta:      { browser: ua.browser },
});

// View per user
app.get('/me/audit', requireAuth, async (req, res) =>
  res.json(await AuditLog.find({ userId: req.user.id }).limit(50).sort('-createdAt'))
);", 'typescript'));

    $p[] = $T::slide(15, $total, 'Secrets Management',
        $T::bulletList([
            'Never commit <code class="sba-inline">.env</code>',
            'Rotate JWT secrets on a schedule (every 90 days)',
            'Use a secrets manager in production (AWS Secrets, Doppler, HCP Vault)',
            'Different keys for dev / staging / prod',
            'Scan commits with <code class="sba-inline">git-secrets</code> or <code class="sba-inline">trufflehog</code>',
        ]));

    $p[] = $T::slide(16, $total, 'AI Prompt For A Hardened Login',
        $T::codeBlock(
"Build a POST /auth/login endpoint for Express 5 + TypeScript:

SECURITY:
 - Argon2id for password verify
 - Rate-limit 5 per 15min per (email + ip)
 - Issue 15-minute JWT access and 30-day refresh (httpOnly cookie)
 - Return minimal user info + access token
 - On failure, return generic 'invalid credentials' (no enumeration)
 - Log attempts for audit

Test: Vitest + Supertest for happy path, wrong password, rate-limit.
Output: the controller, service, route, and test file.", 'prompt'));

    $p[] = $T::slide(17, $total, 'Testing Auth Flows',
        $T::codeBlock(
"test('blocks brute force', async () => {
  for (let i = 0; i < 6; i++) {
    await request(app).post('/auth/login').send({ email: 'a@b.com', password: 'x' });
  }
  const res = await request(app).post('/auth/login').send({ email: 'a@b.com', password: 'x' });
  expect(res.status).toBe(429);
});", 'typescript'));

    $p[] = $T::slide(18, $total, 'Social Login (OAuth)',
        $T::bulletList([
            'Use <b>passport</b> + strategies (Google, GitHub, Apple)',
            'Or <b>Auth0 / Clerk / Supabase Auth</b> for hosted',
            'Flow: redirect → provider → callback → create/find user → issue JWT',
            'Always fetch emails from the provider; trust them as verified',
            'Store provider + provider_user_id on your User table',
        ]));

    $p[] = $T::slide(19, $total, '2FA & Passwordless',
        $T::bulletList([
            'TOTP via <code class="sba-inline">otplib</code> — QR code onboarding',
            'Email magic links — sign the user in via a single-use link',
            'WebAuthn (passkeys) — phishing-resistant, Apple/Google push',
            'SMS is still common but weakest — never the sole factor',
            'Store encrypted 2FA secrets; never log OTPs',
        ]));

    $p[] = $T::slide(20, $total, 'Key Takeaways', $T::bulletList([
        'Hash with Argon2id, verify with constant-time compare',
        'JWT access (short) + refresh (long, rotated) in httpOnly cookie',
        'Rate-limit login, verify email, reset with short-lived tokens',
        'Helmet + HTTPS + CSRF + validation protect the perimeter',
        'Audit log every sensitive action',
    ]), 'sba-recap');

    $p[] = $T::slide(21, $total, 'Up Next — Lesson 18',
        $T::lead('Three modules down. Time to assemble everything: <b>Project #2 — Build a Complete MERN E-commerce Store</b>.'));

    return $T::deckOpen() . implode("\n", $p) . $T::deckClose();
}

function lesson_18_content(): string {
    $T = 'SlideTemplate'; $total = 22;
    $p = [];
    $p[] = $T::cover(18, 24,
        'Project #2 — Build a Complete MERN E-commerce Store',
        'Combine everything: Node + Express + MongoDB + React + TypeScript + Tailwind + Zustand + TanStack Query into one shipped-ready e-commerce site.',
        'Module 4', '6h');

    $p[] = $T::slide(2, $total, 'Architecture Overview',
        $T::cardGrid([
            ['icon' => '🎨', 'title' => 'Frontend', 'text' => 'Vite + React 19 + TS + Tailwind + shadcn/ui + Zustand + TanStack Query'],
            ['icon' => '🧠', 'title' => 'Backend', 'text' => 'Node 22 + Express 5 + TS + Zod + Pino + Helmet', 'color' => 'sba-pink'],
            ['icon' => '💾', 'title' => 'Data', 'text' => 'MongoDB Atlas (free M0) with Mongoose', 'color' => 'sba-cyan'],
            ['icon' => '🔐', 'title' => 'Auth', 'text' => 'JWT access + httpOnly refresh + Argon2id', 'color' => 'sba-green'],
        ], 2));

    $p[] = $T::slide(3, $total, 'Monorepo Layout',
        $T::codeBlock(
"mern-shop/
├── apps/
│   ├── api/            (from lessons 15-17)
│   └── web/            (from lesson 10)
├── packages/
│   └── shared/
│       └── types.ts     # Product, Order, Cart shapes shared by both
├── package.json
└── pnpm-workspace.yaml", 'text'));

    $p[] = $T::slide(4, $total, 'Shared Types (packages/shared/types.ts)',
        $T::codeBlock(
"export interface Product {
  id:          string;
  name:        string;
  slug:        string;
  priceCents:  number;
  stock:       number;
  image:       string;
  categoryId:  string;
}
export interface CartLine { productId: string; qty: number; }
export interface Order {
  id:          string;
  items:       Array<{ productId: string; priceCents: number; qty: number; }>;
  total:       number;
  status:      'pending' | 'paid' | 'shipped' | 'cancelled';
  createdAt:   string;
}", 'typescript'));

    $p[] = $T::slide(5, $total, 'API Endpoints We Need',
        $T::table(['Method', 'Endpoint', 'Purpose'], [
            ['POST', '/auth/register', 'Sign up'],
            ['POST', '/auth/login', 'Sign in'],
            ['POST', '/auth/refresh', 'Rotate access'],
            ['POST', '/auth/logout', 'Invalidate refresh'],
            ['GET',  '/products', 'Paginated catalog'],
            ['GET',  '/products/:slug', 'Single product'],
            ['POST', '/cart', 'Sync server cart (auth)'],
            ['POST', '/orders', 'Place order'],
            ['GET',  '/orders', 'My orders'],
            ['POST', '/reviews', 'Post review'],
        ]));

    $p[] = $T::slide(6, $total, 'Auth Flow End-To-End',
        $T::numberedList([
            'User registers → backend stores Argon2 hash → sends verification email',
            'User clicks email link → account verified',
            'User logs in → receives access (15 min) + refresh (httpOnly cookie)',
            'Frontend stores access in memory (zustand) and calls APIs with Bearer',
            'On 401 response, frontend hits <code class="sba-inline">/auth/refresh</code> → new access',
            'Logout → frontend deletes cookie + clears store',
        ]));

    $p[] = $T::slide(7, $total, 'Frontend API Client',
        $T::codeBlock(
"// web/src/lib/api.ts
import { useAuth } from '../stores/auth';

export async function api<T>(path: string, init: RequestInit = {}): Promise<T> {
  const access = useAuth.getState().access;
  const res = await fetch(import.meta.env.VITE_API_URL + path, {
    ...init,
    credentials: 'include',
    headers: {
      ...(init.headers ?? {}),
      'Content-Type': 'application/json',
      ...(access ? { Authorization: `Bearer \${access}` } : {}),
    }
  });
  if (res.status === 401) {
    const refreshed = await refresh();
    if (refreshed) return api<T>(path, init);  // retry once
    throw new Error('unauthenticated');
  }
  if (!res.ok) throw new Error((await res.json()).error ?? res.statusText);
  return res.json();
}", 'typescript'));

    $p[] = $T::slide(8, $total, 'Auth Store',
        $T::codeBlock(
"// web/src/stores/auth.ts
interface AuthState {
  access: string | null;
  user:   { id: string; name: string; email: string } | null;
  setAccess: (a: string | null) => void;
  setUser:   (u: AuthState['user']) => void;
  logout:    () => Promise<void>;
}
export const useAuth = create<AuthState>((set) => ({
  access: null,
  user:   null,
  setAccess: (access) => set({ access }),
  setUser:   (user) => set({ user }),
  logout:    async () => {
    await fetch('/auth/logout', { method: 'POST', credentials: 'include' });
    set({ access: null, user: null });
  },
}));", 'typescript'));

    $p[] = $T::slide(9, $total, 'Cart Sync Strategy',
        $T::codeBlock(
"// Guests: cart in localStorage (Zustand persist)
// Users:  server persists cart in the DB; local syncs on login.

useEffect(() => {
  if (user) {
    // fetch server cart on login
    api('/cart').then(remote => {
      const merged = merge(local.lines, remote.lines);
      pushToServer(merged);
      setLines(merged);
    });
  }
}, [user]);", 'typescript'));

    $p[] = $T::slide(10, $total, 'Placing An Order',
        $T::codeBlock(
"// POST /orders — backend
app.post('/orders', requireAuth, async (req, res) => {
  const payload = orderSchema.parse(req.body);
  const session = await mongoose.startSession();
  session.startTransaction();
  try {
    const products = await Product.find({ _id: { \$in: payload.items.map(i => i.productId) } }).session(session);
    for (const item of payload.items) {
      const p = products.find(x => x.id === item.productId);
      if (!p || p.stock < item.qty) throw new HttpError(409, 'out of stock');
      p.stock -= item.qty; await p.save({ session });
    }
    const order = await Order.create([{ ...payload, userId: req.user.id }], { session });
    await session.commitTransaction();
    res.status(201).json(order[0]);
  } catch (e) { await session.abortTransaction(); next(e); }
});", 'typescript'));

    $p[] = $T::slide(11, $total, 'Reviews With Moderation',
        $T::codeBlock(
"// schema
const reviewSchema = new Schema({
  userId:    { type: Types.ObjectId, ref: 'User',    required: true },
  productId: { type: Types.ObjectId, ref: 'Product', required: true, index: true },
  rating:    { type: Number, min: 1, max: 5, required: true },
  body:      String,
  status:    { type: String, enum: ['pending','approved','rejected'], default: 'pending' },
}, { timestamps: true });

// After approval, update product aggregate rating (a pre-save hook
// on Review or a queue job that recomputes on approval).", 'typescript'));

    $p[] = $T::slide(12, $total, 'Image Uploads (S3-Compatible)',
        $T::codeBlock(
"// Use Cloudflare R2 or DigitalOcean Spaces (both S3-compatible + cheap)
import { S3Client, PutObjectCommand } from '@aws-sdk/client-s3';
const s3 = new S3Client({ region: 'auto', endpoint: env.R2_ENDPOINT, credentials: { accessKeyId: env.R2_KEY, secretAccessKey: env.R2_SECRET } });

await s3.send(new PutObjectCommand({
  Bucket: 'shop-media',
  Key: `products/\${Date.now()}-\${file.originalname}`,
  Body: file.buffer,
  ContentType: file.mimetype,
  ACL: 'public-read',
}));", 'typescript'));

    $p[] = $T::slide(13, $total, 'Frontend Product Page — Reviews & Cart',
        $T::codeBlock(
"function ProductPage({ slug }: { slug: string }) {
  const { data: product } = useQuery({
    queryKey: ['products', slug],
    queryFn:  () => api<Product>(`/products/\${slug}`),
  });
  const { data: reviews } = useQuery({
    queryKey: ['reviews', slug],
    queryFn:  () => api<Review[]>(`/products/\${slug}/reviews`),
    enabled:  !!product,
  });
  const addToCart = useCart(s => s.add);
  if (!product) return <Skeleton/>;
  return (
    <article>
      <Gallery images={product.images}/>
      <h1>{product.name}</h1>
      <p>\${(product.priceCents/100).toFixed(2)}</p>
      <button onClick={() => addToCart(product)}>Add to cart</button>
      <ReviewList reviews={reviews ?? []}/>
    </article>
  );
}", 'typescript'));

    $p[] = $T::slide(14, $total, 'Admin Dashboard (Filament-style In React)',
        $T::bulletList([
            'Route-guard <code class="sba-inline">/admin/*</code> with <code class="sba-inline">role==="admin"</code>',
            'Tables using <b>TanStack Table</b> with sorting + filtering',
            'Charts using <b>Recharts</b> — daily revenue, top products',
            'Product CRUD drawer with shadcn/ui Dialog',
            'Order detail page with shipping + refund buttons',
        ]));

    $p[] = $T::slide(15, $total, 'Seeding Data For The Demo',
        $T::codeBlock(
"// scripts/seed.ts
const categories = ['Watches','Bags','Jewellery','Accessories']
  .map(name => ({ name, slug: name.toLowerCase() }));
await Category.insertMany(categories);

const products = Array.from({ length: 40 }, (_, i) => ({
  name:        faker.commerce.productName(),
  slug:        faker.helpers.slugify(`p-\${i}-\${faker.string.nanoid(4)}`).toLowerCase(),
  priceCents:  faker.number.int({ min: 1000, max: 99900 }),
  stock:       faker.number.int({ min: 0, max: 200 }),
  image:       faker.image.urlLoremFlickr({ category: 'product' }),
  categoryId:  faker.helpers.arrayElement(categories).id,
}));
await Product.insertMany(products);", 'typescript'));

    $p[] = $T::slide(16, $total, 'CI/CD',
        $T::codeBlock(
".github/workflows/ci.yml
name: CI
on: [push, pull_request]
jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: pnpm/action-setup@v3
      - uses: actions/setup-node@v4
        with: { node-version: 22, cache: pnpm }
      - run: pnpm i
      - run: pnpm -r test
      - run: pnpm -r build", 'yaml'));

    $p[] = $T::slide(17, $total, 'Deployment Previews',
        $T::bulletList([
            'Frontend: Vercel / Cloudflare Pages (both free for hobby)',
            'Backend: Render / Fly.io / Railway / DigitalOcean App Platform',
            'DB: MongoDB Atlas (free tier)',
            'Images: Cloudflare R2 (10GB free)',
            'We\'ll ship the full thing to Hostinger in lesson 23',
        ]));

    $p[] = $T::slide(18, $total, 'Observability',
        $T::bulletList([
            'Logs — pino + Logtail or Better Stack',
            'Errors — Sentry SDK (free tier)',
            'Uptime — Better Stack or Pingdom',
            'Performance — Vercel Analytics, or web-vitals + POST /vitals',
            'Dashboard — Grafana Cloud free tier',
        ]));

    $p[] = $T::slide(19, $total, 'Common MERN Project Bugs',
        $T::bulletList([
            'CORS misconfiguration — allow only your frontend origin',
            'Cookies not sent — remember <code class="sba-inline">credentials:"include"</code> + exact origin',
            'ObjectId stringify issues — use <code class="sba-inline">toJSON</code> transform',
            'Race conditions on <code class="sba-inline">stock</code> — always use <code class="sba-inline">$inc</code> with a condition',
            'Missing 401 → refresh retry loop — always back off after one retry',
        ]));

    $p[] = $T::slide(20, $total, 'Your Deliverables',
        $T::numberedList([
            'GitHub monorepo with <code class="sba-inline">apps/web</code> and <code class="sba-inline">apps/api</code>',
            'README with architecture diagram + setup',
            'Screenshots of product page, cart, checkout, admin',
            '10+ Vitest tests passing in CI',
            'Deployed previews of both web and api',
        ]));

    $p[] = $T::slide(21, $total, 'Key Takeaways', $T::bulletList([
        'Share types between API and UI — prevents entire classes of bugs',
        'Access in memory, refresh in httpOnly cookie',
        'Guest cart local, user cart on server; merge on login',
        'Transactions for order placement — never undershoot stock',
        'CI, Sentry, pino — observability from day one',
    ]), 'sba-recap');

    $p[] = $T::slide(22, $total, 'Up Next — Lesson 19',
        $T::lead('Two stacks mastered. Now the stack that runs 43% of the web for non-developers: <b>WordPress &amp; WooCommerce</b>.'));

    return $T::deckOpen() . implode("\n", $p) . $T::deckClose();
}

function lesson_19_content(): string {
    $T = 'SlideTemplate'; $total = 21;
    $p = [];
    $p[] = $T::cover(19, 24,
        'WordPress Mastery — Themes, Plugins & the Block Editor',
        'WordPress powers 43% of all websites and ~65% of all CMS-driven sites. Become a professional WordPress developer: themes, plugins, block editor, and AI workflows.',
        'Module 5', '4h');

    $p[] = $T::slide(2, $total, 'Why WordPress (Still)', $T::bulletList([
        'One-click setup on Hostinger, SiteGround, and every shared host',
        'Massive plugin ecosystem — 59,000+ free plugins',
        'Great for clients — familiar editor, easy to train',
        'Open source, GPL-licensed, runs on LAMP stack',
        'You can embed React (Gutenberg blocks) if you want modern UX',
    ]));

    $p[] = $T::slide(3, $total, 'Installing WordPress Locally',
        $T::cardGrid([
            ['icon' => '💻', 'title' => 'LocalWP', 'text' => 'Free one-click installer. Isolated containers for each site.'],
            ['icon' => '🐳', 'title' => 'DDEV', 'text' => 'Docker-based, great for teams.', 'color' => 'sba-pink'],
            ['icon' => '🛠️', 'title' => 'XAMPP / MAMP', 'text' => 'Classic stack; more manual.', 'color' => 'sba-cyan'],
        ], 3) .
        $T::callout('success', 'Recommendation', 'Use LocalWP — signup-free, one-click, automatic HTTPS.'));

    $p[] = $T::slide(4, $total, 'WordPress File Layout',
        $T::codeBlock(
"/wp-admin/        (admin UI — do not edit)
/wp-includes/     (core — do not edit)
/wp-content/
  ├── plugins/            ← install plugins here
  ├── themes/             ← build/edit themes here
  ├── uploads/            ← media
  └── mu-plugins/         ← \"must-use\" custom code
/wp-config.php    ← DB credentials + salts", 'text'));

    $p[] = $T::slide(5, $total, 'The Two Worlds Of WordPress',
        $T::cardGrid([
            ['icon' => '🧱', 'title' => 'Classic PHP + Blade-like', 'text' => 'functions.php, custom themes, Elementor, ACF.'],
            ['icon' => '⚛️', 'title' => 'Block / FSE (React)', 'text' => 'Full-Site Editing, block themes, React blocks.', 'color' => 'sba-pink'],
        ], 2));

    $p[] = $T::slide(6, $total, 'The Admin Dashboard Tour',
        $T::bulletList([
            '<b>Posts / Pages</b> — content',
            '<b>Media</b> — uploaded files',
            '<b>Appearance</b> → Themes, Editor (FSE), Customiser, Widgets',
            '<b>Plugins</b> — install from repo or upload ZIP',
            '<b>Users</b> — roles: Admin, Editor, Author, Contributor, Subscriber',
            '<b>Tools</b> → Site Health, Import/Export',
            '<b>Settings</b> → General, Permalinks (Pretty URLs!), Discussion',
        ]));

    $p[] = $T::slide(7, $total, 'Plugins You Actually Want',
        $T::table(['Plugin', 'Purpose'], [
            ['Advanced Custom Fields (ACF)', 'Custom fields for any post type'],
            ['WP Rocket / LiteSpeed Cache', 'Performance & caching'],
            ['Yoast SEO / RankMath', 'On-page SEO'],
            ['WooCommerce', 'E-commerce'],
            ['WP Mail SMTP', 'Reliable transactional email'],
            ['UpdraftPlus / BackupBuddy', 'Automated backups'],
            ['Wordfence / Solid Security', 'Security'],
            ['Elementor / Kadence', 'Drag-n-drop builders'],
        ]));

    $p[] = $T::slide(8, $total, 'Building A Classic Theme (functions.php)',
        $T::codeBlock(
"// wp-content/themes/swissbridge/functions.php
<?php
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form','comment-form','comment-list']);
    register_nav_menus([ 'primary' => 'Main menu', 'footer' => 'Footer' ]);
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('theme',  get_stylesheet_uri());
    wp_enqueue_script('theme', get_template_directory_uri().'/app.js', [], '1.0', true);
});", 'php'));

    $p[] = $T::slide(9, $total, 'The Template Hierarchy',
        $T::codeBlock(
"index.php          ← fallback
home.php           ← posts page
front-page.php     ← static homepage
page.php           ← single page
page-{slug}.php    ← specific page slug
single.php         ← single post
single-{cpt}.php   ← single of a custom post type
archive.php        ← all posts / category
404.php            ← not found
header.php, footer.php, sidebar.php  ← partials", 'text'));

    $p[] = $T::slide(10, $total, 'Custom Post Type (CPT)',
        $T::codeBlock(
"register_post_type('product', [
  'labels'       => ['name' => 'Products', 'singular_name' => 'Product'],
  'public'       => true,
  'show_in_rest' => true,             // expose in block editor + REST
  'menu_icon'    => 'dashicons-cart',
  'supports'     => ['title','editor','thumbnail','excerpt','custom-fields'],
  'has_archive'  => true,
  'rewrite'      => ['slug' => 'products'],
]);

register_taxonomy('product_category', 'product', [
  'public' => true, 'hierarchical' => true, 'show_in_rest' => true,
  'rewrite' => ['slug' => 'categories'],
]);", 'php'));

    $p[] = $T::slide(11, $total, 'ACF Fields',
        $T::paragraph('With Advanced Custom Fields installed, you define fields in the admin UI (or as JSON) and read them with <code class="sba-inline">get_field()</code>:') .
        $T::codeBlock(
"<h1><?php the_title(); ?></h1>
<p class=\"price\">\$<?php echo get_field('price'); ?></p>
<p class=\"sku\">SKU: <?php echo get_field('sku'); ?></p>

\$gallery = get_field('gallery');
foreach (\$gallery as \$img) {
  echo '<img src=\"' . esc_url(\$img['sizes']['large']) . '\">';
}", 'php'));

    $p[] = $T::slide(12, $total, 'REST API',
        $T::codeBlock(
"GET /wp-json/wp/v2/posts
GET /wp-json/wp/v2/product        (for CPT with show_in_rest)
POST /wp-json/wp/v2/posts   (auth required)

// Register a custom endpoint
add_action('rest_api_init', function () {
    register_rest_route('sba/v1', '/summary', [
        'methods'  => 'GET',
        'callback' => fn() => [
            'posts' => wp_count_posts()->publish,
            'users' => count_users()['total_users'],
        ],
        'permission_callback' => '__return_true',
    ]);
});", 'php'));

    $p[] = $T::slide(13, $total, 'Creating A Block (React)',
        $T::codeBlock(
"// src/pricing-block/index.js
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText } from '@wordpress/block-editor';

registerBlockType('sba/pricing', {
  title: 'Pricing Card',
  icon:  'tag',
  category: 'design',
  attributes: {
    title: { type: 'string', default: 'Pro' },
    price: { type: 'string', default: '\$9' },
  },
  edit({ attributes, setAttributes }) {
    const props = useBlockProps();
    return (
      <div {...props} className=\"pricing-card\">
        <RichText tagName=\"h3\" value={attributes.title} onChange={title => setAttributes({title})}/>
        <RichText tagName=\"p\"  value={attributes.price} onChange={price => setAttributes({price})}/>
      </div>
    );
  },
  save({ attributes }) {
    return (
      <div className=\"pricing-card\">
        <h3>{attributes.title}</h3>
        <p>{attributes.price}</p>
      </div>
    );
  },
});", 'typescript') .
        $T::callout('info', 'Build',
            'Use <code class="sba-inline">@wordpress/scripts</code> — zero-config Webpack bundler.'));

    $p[] = $T::slide(14, $total, 'Hooks — Actions & Filters',
        $T::codeBlock(
"// Action — do something at a lifecycle point
add_action('wp_footer', function () {
  echo '<script>console.log(\"hi\")</script>';
});

// Filter — modify a value
add_filter('the_content', function (\$content) {
  return \$content . '<p>— Read more on our blog!</p>';
});

// Remove a hook
remove_action('wp_head', 'wp_generator');", 'php'));

    $p[] = $T::slide(15, $total, 'Child Themes',
        $T::paragraph('Never edit the parent theme. Create a child theme so updates don\'t overwrite your changes.') .
        $T::codeBlock(
"// wp-content/themes/twenty-twenty-five-child/style.css
/*
Theme Name:   Twenty Twenty-Five Child
Template:     twentytwentyfive
Version:      1.0
*/

// functions.php
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('parent', get_template_directory_uri().'/style.css');
});", 'php'));

    $p[] = $T::slide(16, $total, 'Security Basics',
        $T::bulletList([
            'Use application passwords, not your admin password, for API calls',
            'Install Wordfence or Solid Security',
            'Keep core, themes, plugins updated',
            'Limit login attempts (plugin or fail2ban)',
            'Disable <code class="sba-inline">wp-admin</code> for non-admin users',
            'Use SSL (auto on Hostinger) and HSTS',
        ]));

    $p[] = $T::slide(17, $total, 'Performance & Caching',
        $T::bulletList([
            'Object cache (Redis / Memcached)',
            'Page cache (LiteSpeed, WP Rocket)',
            'Image optimisation (WebP, lazy-load)',
            'CDN (Cloudflare)',
            'Use PHP 8.3 + OPcache',
        ]));

    $p[] = $T::slide(18, $total, 'AI With WordPress',
        $T::bulletList([
            'Use ChatGPT to outline posts, then paste into block editor',
            'Plugins: "AI Engine", "GetGenie", "ContentBot" for on-page AI',
            'Cursor for building custom blocks & plugins',
            'Use Claude to audit custom functions.php for security',
            'AI alt-text plugins for images — automatic accessibility',
        ]));

    $p[] = $T::slide(19, $total, 'AI Prompt For A Custom Plugin',
        $T::codeBlock(
"Generate a WordPress plugin 'sba-products-api'.

 - Registers a CPT 'product' with support for thumbnail + ACF
 - Adds REST route GET /wp-json/sba/v1/products?category=x
   returning id, title, price, thumbnail, permalink (paginated 20)
 - Ensures show_in_rest on the CPT
 - Escapes output with esc_html, wp_kses_post
 - Follows WordPress PHP coding standards

Output: plugin header, main file, and folder structure notes.", 'prompt'));

    $p[] = $T::slide(20, $total, 'Key Takeaways', $T::bulletList([
        'WordPress = core + themes + plugins; you edit only the last two',
        'Custom Post Types + ACF = content-management super-power',
        'REST API turns WordPress into a headless CMS',
        'Build blocks with React + <code class="sba-inline">@wordpress/scripts</code>',
        'Security = updates, strong passwords, limited logins, HTTPS',
    ]), 'sba-recap');

    $p[] = $T::slide(21, $total, 'Up Next — Lesson 20',
        $T::lead('Time to sell. Next: <b>Project #3 — Build a WordPress + WooCommerce Store</b>.'));

    return $T::deckOpen() . implode("\n", $p) . $T::deckClose();
}

function lesson_20_content(): string {
    $T = 'SlideTemplate'; $total = 22;
    $p = [];
    $p[] = $T::cover(20, 24,
        'Project #3 — Build a WordPress + WooCommerce Store',
        'Ship a professional e-commerce site in hours, not weeks: WooCommerce setup, Stripe + PayPal payments, shipping zones, a custom theme, and AI-assisted product copy.',
        'Module 5', '5h 30m');

    $p[] = $T::slide(2, $total, 'WooCommerce In Numbers', $T::bulletList([
        '28% of all online stores worldwide',
        '6+ million active installs',
        'Free, open-source, GPL-licensed',
        'Hundreds of payment gateways',
        'Themes & add-ons for any use case',
    ]));

    $p[] = $T::slide(3, $total, 'Installation',
        $T::numberedList([
            'WordPress admin → Plugins → Add New → search "WooCommerce"',
            'Install &amp; activate',
            'Run the setup wizard: store address, currency, industry',
            'Add tax regions, shipping zones, payment methods',
            'Install storefront-friendly theme (Storefront, Kadence, Blocksy)',
        ]));

    $p[] = $T::slide(4, $total, 'Core WooCommerce Concepts',
        $T::table(['Object', 'Description'], [
            ['Product', 'Simple, variable (size/color), grouped, external'],
            ['Category / Tag', 'Taxonomy for browsing'],
            ['Attribute', 'Color, size — used for variations'],
            ['Order', 'Lifecycle: pending → processing → completed'],
            ['Coupon', 'Discount codes — percent, fixed, BOGO'],
            ['Customer', 'Extends WP User with billing + shipping'],
            ['Shipping Zone', 'Regions + shipping methods per zone'],
        ]));

    $p[] = $T::slide(5, $total, 'Payment Gateways',
        $T::bulletList([
            '<b>Stripe</b> — free plugin, Apple/Google Pay supported',
            '<b>PayPal</b> — built-in',
            '<b>Razorpay</b> — for India',
            '<b>Mollie</b> — European-friendly',
            '<b>Square</b>, <b>Authorize.net</b>, <b>Klarna</b>, <b>AfterPay</b>',
            'Manual — bank transfer, cash on delivery',
        ]));

    $p[] = $T::slide(6, $total, 'Adding A Product',
        $T::numberedList([
            'Products → Add New → title, description, excerpt, featured image',
            'Product data → Simple product → Regular price / Sale price',
            'Inventory tab → SKU, stock quantity, low-stock threshold',
            'Shipping tab → weight, dimensions → used for rate calculation',
            'Linked products → upsells, cross-sells',
            'Attributes → add color, size for variations',
            'Advanced → purchase note, enable reviews, menu order',
            'Categories + tags + product image in sidebar',
            'Publish',
        ]));

    $p[] = $T::slide(7, $total, 'Variable Products',
        $T::codeBlock(
"Attributes:
  Size:  S | M | L | XL
  Color: Black | White | Red

Generate variations automatically → set price, stock, image per variation.
Shopper picks size + color on the product page → right variation added to cart.", 'text'));

    $p[] = $T::slide(8, $total, 'Shipping Zones & Classes',
        $T::numberedList([
            'WooCommerce → Settings → Shipping → Add Shipping Zone',
            'Define region (e.g. United States, EU, Switzerland)',
            'Add method: Flat rate / Free shipping / Local pickup / Real-time (DHL, FedEx via plugin)',
            'Shipping classes → optional, to group heavy/fragile items',
        ]));

    $p[] = $T::slide(9, $total, 'Tax',
        $T::bulletList([
            'Settings → General → Enable tax',
            'Settings → Tax → tax rates per region',
            'Or plug in <b>Avalara</b> / <b>TaxJar</b> for automation',
            'Swiss & EU VAT — use "Prices include tax" mode',
            'Test with a low-tax and high-tax region',
        ]));

    $p[] = $T::slide(10, $total, 'Customizing The Storefront Theme',
        $T::codeBlock(
"/* child theme style.css */
.woocommerce ul.products li.product h2 {
  font-family: 'Inter', sans-serif;
  font-size: 1.125rem;
  font-weight: 600;
}
.woocommerce .button.alt {
  background: linear-gradient(135deg,#6366f1,#ec4899);
  border: none;
  border-radius: 0.75rem;
}

/* child theme functions.php */
add_filter('woocommerce_currency_symbol', function (\$s, \$c) {
  return \$c === 'CHF' ? 'CHF ' : \$s;
}, 10, 2);", 'php'));

    $p[] = $T::slide(11, $total, 'Template Overrides',
        $T::codeBlock(
"// Copy a WooCommerce template into your theme to override it:
wp-content/plugins/woocommerce/templates/single-product/meta.php
→ wp-content/themes/your-child/woocommerce/single-product/meta.php

WooCommerce auto-uses your override. Document with the version
header to stay in sync when Woo updates.", 'text'));

    $p[] = $T::slide(12, $total, 'WooCommerce Hooks',
        $T::codeBlock(
"// Add content before 'add to cart'
add_action('woocommerce_before_add_to_cart_button', function () {
    echo '<p class=\"eco-badge\">🌿 Ethically sourced</p>';
});

// Change price display
add_filter('woocommerce_get_price_html', function (\$html, \$product) {
  if (\$product->is_on_sale()) return '<span class=\"sale\">'.\$html.'</span>';
  return \$html;
}, 10, 2);

// Send admin email on low-stock alert (built-in) — just enable it", 'php'));

    $p[] = $T::slide(13, $total, 'Custom Fields For Products',
        $T::paragraph('Use ACF to add fields like "Care instructions" or "Country of origin".') .
        $T::codeBlock(
"// template: single-product/tabs/description.php
<?php
\$care = get_field('care_instructions', get_the_ID());
if (\$care) echo '<h4>Care</h4><p>'.esc_html(\$care).'</p>';
?>", 'php'));

    $p[] = $T::slide(14, $total, 'Reports & Analytics',
        $T::bulletList([
            'Built-in Analytics dashboard → revenue, orders, customers, products',
            'Google Analytics 4 via WooCommerce plugin',
            'Meta Pixel for ads',
            'Hotjar for user session recording',
            'Mailchimp / Klaviyo for email marketing integration',
        ]));

    $p[] = $T::slide(15, $total, 'Security & GDPR',
        $T::bulletList([
            'Force HTTPS site-wide',
            'Disable "Comments" on products unless you moderate',
            'Privacy Policy page linked in footer',
            'Consent banner (Complianz or Iubenda plugin)',
            'Remove billing data after X days (tools)',
            'Disable <code class="sba-inline">XML-RPC</code> and <code class="sba-inline">wp-login</code> brute force via Wordfence',
        ]));

    $p[] = $T::slide(16, $total, 'Performance For WooCommerce',
        $T::bulletList([
            'PHP 8.2+ with OPcache & JIT',
            'Redis object cache',
            'WP Rocket or LiteSpeed page cache with rules for cart/checkout exclusions',
            'Image CDN (Bunny, Cloudflare)',
            'Audit with Query Monitor plugin',
        ]));

    $p[] = $T::slide(17, $total, 'AI-Powered Product Copy',
        $T::codeBlock(
"Prompt:
 You are a luxury e-commerce copywriter.
 Write a 120-word product description for:
   Name: 'Swiss Classic Chrono'
   Features: Automatic movement, sapphire crystal, 42mm case,
             leather strap, 100m water resistance
   Tone: Refined, confident, not hype-y
 Return the description + 5 SEO keywords.", 'prompt'));

    $p[] = $T::slide(18, $total, 'AI Prompt — Custom Wo Hook',
        $T::codeBlock(
"Write a WooCommerce snippet that:
 - Adds a 'Gift wrap +\$5' checkbox on the cart page
 - If checked, adds a fee to the order total
 - Shows the wrap choice in the admin order details
 - Persists the choice across cart refreshes
Use WooCommerce hooks (woocommerce_before_calculate_totals, etc).
Follow WooCommerce coding standards. Secure & escaped.", 'prompt'));

    $p[] = $T::slide(19, $total, 'Abandoned Cart Recovery',
        $T::bulletList([
            'Plugin: CartBounty / Abandoned Cart Lite',
            'Store carts in DB; capture email early at checkout',
            'Auto-send 3 recovery emails at 1h, 24h, 72h',
            'A/B test subject lines and discount offers',
            'Average recovery = 10-20% of abandoned revenue',
        ]));

    $p[] = $T::slide(20, $total, 'Your Deliverable — Launched Shop',
        $T::numberedList([
            '20 products with real images and AI-written descriptions',
            '5 categories, 10 tags',
            'Stripe + PayPal in test mode',
            'Shipping zones: your country + international flat rate',
            'Custom child theme with branded colours',
            'At least one custom block or hook',
            'Demo video walking through a test purchase',
        ]));

    $p[] = $T::slide(21, $total, 'Key Takeaways', $T::bulletList([
        'WooCommerce + a good theme = a real store in under a day',
        'Stripe + PayPal cover 95% of customers',
        'Child themes + overrides keep you update-safe',
        'Hooks let you change WooCommerce\'s behaviour without editing core',
        'AI writes faster and often better product copy',
    ]), 'sba-recap');

    $p[] = $T::slide(22, $total, 'Up Next — Lesson 21',
        $T::lead('Three shops shipped! Now we zoom out: <b>SEO, Analytics & Core Web Vitals</b>.'));

    return $T::deckOpen() . implode("\n", $p) . $T::deckClose();
}
