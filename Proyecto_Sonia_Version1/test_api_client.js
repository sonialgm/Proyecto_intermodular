// Testear API como si fuera un cliente real. Usa fetch y una capa cliente JS
const API_URL = "http://localhost/anonimas/proyectoTres/api.php";

console.log("Testeando API REST - Conversaciones Anónimas");
console.log("=".repeat(50));

async function show(title, fn) {
  console.log(`\n${title}`);
  console.log("-".repeat(50));
  try {
    const result = await fn();
    console.log("[OK] Respuesta:");
    console.log(result);
  } catch (err) {
    console.log("[KO] Error:");
    console.log(err.message);
  }
}

// Funciones cliente para la API
const ConversationAPI = {
  getAll: async () => {
    const res = await fetch(`${API_URL}/conversaciones`);
    return res.json();
  },
  get: async (codigo) => {
    const res = await fetch(`${API_URL}/conversaciones/${codigo}`);
    return res.json();
  },
  create: async (password) => {
    const res = await fetch(`${API_URL}/conversaciones`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ password }),
    });
    return res.json();
  }
};

(async () => {
  let codigoGenerado = null;

  await show("1️⃣ GET - Listar todas las conversaciones", () =>
    ConversationAPI.getAll()
  );

  await show("2️⃣ POST - Crear nueva conversación", async () => {
    const conv = await ConversationAPI.create("123");
    codigoGenerado = conv.codigo;
    return conv;
  });

  await show("3️⃣ GET - Verificar conversación creada", () =>
    ConversationAPI.get(codigoGenerado)
  );

  console.log("\n✅ Test completado!");
})();
