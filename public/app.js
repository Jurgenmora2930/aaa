const form = document.querySelector("#vectorForm");
const statusEl = document.querySelector("#status");
const resultEl = document.querySelector("#result");
const outputEl = document.querySelector("#svgOutput");
const previewEl = document.querySelector("#preview");
const downloadBtn = document.querySelector("#downloadBtn");

let lastFileName = "imagen.svg";

form.addEventListener("submit", async (event) => {
  event.preventDefault();
  statusEl.textContent = "Vectorizando...";
  resultEl.classList.add("hidden");

  const formData = new FormData(form);

  try {
    const response = await fetch("/api/vectorize", {
      method: "POST",
      body: formData,
    });

    const data = await response.json();

    if (!response.ok) {
      throw new Error(data.error || "No se pudo vectorizar la imagen");
    }

    const { svg, filename } = data;
    lastFileName = filename || "imagen.svg";
    outputEl.value = svg;
    previewEl.innerHTML = svg;
    resultEl.classList.remove("hidden");
    statusEl.textContent = "Listo: imagen convertida a SVG.";
  } catch (error) {
    statusEl.textContent = error instanceof Error ? error.message : "Error inesperado";
  }
});

downloadBtn.addEventListener("click", () => {
  const blob = new Blob([outputEl.value], { type: "image/svg+xml;charset=utf-8" });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = lastFileName;
  a.click();
  URL.revokeObjectURL(url);
});
