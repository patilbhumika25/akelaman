# Akela Website (Render deploy)

This repo builds a **static export** into `dist/` using `@wp-playground/cli` and then deploys it as a **Render Static Site**.

## Deploy on Render

- Create a new **Static Site** on Render and connect this GitHub repo.
- Render will detect `render.yaml` automatically.
- If you are entering settings manually, use:
  - **Build Command**: `npm ci && npm run build`
  - **Publish Directory**: `dist`

## Note on `npm.cmd`

`npm.cmd` is **Windows-only**. Render builds on **Linux**, so the correct command on Render is `npm` (not `npm.cmd`).

