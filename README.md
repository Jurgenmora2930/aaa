# Vectorizer Demo App

Aplicación web en Node.js para convertir imágenes raster (PNG/JPG/WebP) a SVG usando el proyecto [`neplextech/vectorizer`](https://github.com/neplextech/vectorizer).

## Requisitos

- Node.js 18+
- Dependencia `vectorizer` accesible desde npm o GitHub según tu entorno.

## Instalación

```bash
npm install
```

## Ejecutar

```bash
npm start
```

Abre `http://localhost:3000` y sube una imagen para obtener el SVG.

## Estructura

- `server.js`: backend Express + endpoint `/api/vectorize`.
- `public/index.html`: interfaz web.
- `public/app.js`: cliente JS para enviar imagen y descargar SVG.
- `public/styles.css`: estilos de la demo.
