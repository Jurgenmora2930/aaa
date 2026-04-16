import express from "express";
import multer from "multer";
import path from "node:path";
import { fileURLToPath } from "node:url";
import { vectorize } from "vectorizer";

const app = express();
const port = process.env.PORT || 3000;
const upload = multer({ storage: multer.memoryStorage() });

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, "public")));

app.post("/api/vectorize", upload.single("image"), async (req, res) => {
  if (!req.file) {
    return res.status(400).json({ error: "Debes subir una imagen." });
  }

  const options = {
    threshold: Number(req.body.threshold ?? 120),
    despeckle: Number(req.body.despeckle ?? 1),
    simplify: Number(req.body.simplify ?? 1),
  };

  try {
    const result = await vectorize(req.file.buffer, options);
    const svg = typeof result === "string" ? result : result?.svg;

    if (!svg) {
      return res.status(500).json({ error: "Vectorizer no devolvió un SVG válido." });
    }

    return res.json({
      svg,
      filename: `${path.parse(req.file.originalname).name || "imagen"}.svg`,
    });
  } catch (error) {
    return res.status(500).json({
      error: "No se pudo vectorizar la imagen.",
      detail: error instanceof Error ? error.message : "Error desconocido",
    });
  }
});

app.listen(port, () => {
  console.log(`Vectorizer app disponible en http://localhost:${port}`);
});
