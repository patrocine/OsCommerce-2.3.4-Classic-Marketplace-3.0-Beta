





     <!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Desplegable Tokens</title>
<style>
body{
  font-family: Arial;
  padding:20px;
  background:#f4f4f4;
}

.token-container{
  max-width:500px;
  margin:auto;
  padding:20px;
  background:#fff;
  border:1px solid #ccc;
  border-radius:10px;
}

label{
  font-weight:bold;
}

.amountInput{
  width:100px;
  margin-left:10px;
}

.buy-btn{
  margin-left:10px;
  padding:5px 10px;
  background:#28a745;
  color:#fff;
  border:none;
  border-radius:5px;
  cursor:pointer;
}

.buy-btn:hover{
  background:#218838;
}

.resultToken{
  margin-left:10px;
  font-weight:bold;
}

.footer-links{
  display:flex;
  flex-wrap:wrap;
  gap:12px;
  margin-top:20px;
}

.footer-links a{
  border-radius:5px;
  color:white;
  font-size:13px;
  font-weight:600;
  padding:8px 14px;
  text-decoration:none;
}
</style>
</head>
<body>

<div class="token-container">
  <label for="tokenSelect">Seleccione Token:</label>
  <select id="tokenSelect">
    <option value="">--Seleccione--</option>
  </select>

  <div style="margin-top:20px;">
    <label>Importe en EUR:</label>
    <input type="number" class="amountInput" placeholder="0">
    <span>Tokens: <span class="resultToken">0</span></span>
    <button class="buy-btn" id="buyBtn" style="display:none;">Comprar</button>
  </div>
</div>

<div class="carousel-footer" style="margin-top:20px; font-size:14px; color:#333;">
  Pague aqui con USDC y Reclame sus descuentos en criptomonedas de la red de Hedera, consulte al responsable de la empresa
</div>

<div class="footer-links">
  <a href="https://marketplace2024.blogspot.com/2026/01/pagina-de-inicio.html" style="background: rgb(245,124,0);">Seleccione nueva meme</a>
  <strong style="font-size:16px; color:black;">Descargar Wallet:</strong>
  <a href="https://www.hashpack.app/download" style="background: rgb(46,125,50);">HashPack</a>
  <a href="https://www.kabila.app/wallet" style="background: rgb(106,27,154);">Kabila</a>
  <a href="https://www.saucerswap.finance/saucerswap-wallet" style="background: rgb(2,119,189);">SaucerWallet</a>
  <a href="https://marketplace2024.blogspot.com/2026/01/comercios-y-empresas.html" style="background: rgb(106,27,154);" target="_blank">Manual ProInsalacion</a>
</div>

<script>
// -------------------- TOKENS --------------------
const tokens = [
  {name:"RED HEDERA HASHGRAPH HBAR", id:"0.0.1456986", el:"priceHBAR", link:"https://www.saucerswap.finance/trade/HBAR/0.0.4820413"},
  {name:"DELICIA ITALIANA", id:"0.0.5310524", el:"priceDLI", link:"https://www.saucerswap.finance/trade/HBAR/0.0.5310524"},
  {name:"Sr.Marihuano", id:"0.0.5341950", el:"priceSRM", link:"https://www.saucerswap.finance/trade/HBAR/0.0.5341950"},
  {name:"SAUCE", id:"0.0.731861", el:"priceSAUCE", link:"https://www.saucerswap.finance/trade/HBAR/0.0.731861"},
  {name:"PACK", id:"0.0.4794920", el:"pricePACK", link:"https://www.saucerswap.finance/trade/HBAR/0.0.4794920"},
  {name:"DAVINCI", id:"0.0.3706639", el:"priceDAVINCI", link:"https://www.saucerswap.finance/trade/HBAR/0.0.3706639"},
  {name:"KBL", id:"0.0.5989978", el:"priceKBL", link:"https://www.saucerswap.finance/trade/HBAR/0.0.5989978"},
  {name:"ISLAS CANARIAS", id:"0.0.4817159", el:"priceISLAS", link:"https://www.saucerswap.finance/trade/HBAR/0.0.4817159"},
  {name:"BTC.H", id:"0.0.9370957", el:"priceBITCOIN", link:"https://www.saucerswap.finance/trade/HBAR/0.0.9370957"}
];

// -------------------- FORMATO NÚMERO --------------------
function formatNumberEU(value, decimals = 6){
  return Number(value).toLocaleString("es-ES", {
    minimumFractionDigits: decimals,
    maximumFractionDigits: decimals
  });
}

// -------------------- LLENAR SELECT --------------------
const select = document.getElementById("tokenSelect");
tokens.forEach(t=>{
  const option = document.createElement("option");
  option.value = t.id;
  option.textContent = t.name;
  option.dataset.link = t.link;
  select.appendChild(option);
});

// -------------------- PRECIO Y FX --------------------
let eurRate = null;

async function loadFX(){
  const res = await fetch("https://api.frankfurter.app/latest?from=USD&to=EUR");
  const data = await res.json();
  eurRate = data.rates.EUR;
}
loadFX();
setInterval(loadFX,600000);

async function getTokenPrice(id){
  try{
    const res = await fetch(`token.php?id=${id}`);
    const data = await res.json();
    return parseFloat(data.priceUsd);
  }catch(err){
    console.error(err);
    return null;
  }
}

// -------------------- CÁLCULO TOKEN --------------------
const input = document.querySelector(".amountInput");
const resultEl = document.querySelector(".resultToken");
const buyBtn = document.getElementById("buyBtn");

async function calcularTokens(){
  const selectedId = select.value;
  if(!selectedId || !input.value) {
    resultEl.innerText = "0";
    buyBtn.style.display = "none";
    return;
  }

  const priceUSD = await getTokenPrice(selectedId);
  if(!priceUSD || !eurRate){
    resultEl.innerText = "...";
    return;
  }

  const tokensAmount = parseFloat(input.value) / (priceUSD * eurRate);
  resultEl.innerText = formatNumberEU(tokensAmount,6);
  buyBtn.style.display = "inline-block";
}

// -------------------- EVENTOS --------------------
input.addEventListener("input", calcularTokens);
select.addEventListener("change", calcularTokens);
buyBtn.addEventListener("click", ()=>{
  const selectedOption = select.selectedOptions[0];
  if(selectedOption){
    window.open(selectedOption.dataset.link,"_blank","noopener,noreferrer");
  }
});
</script>
</body>
</html>









<?php

?>
