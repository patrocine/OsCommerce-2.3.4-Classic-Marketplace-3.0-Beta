<?php if(isset($HTTP_GET_VARS['ajax']) == false) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
                 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type"
content="text/html; charset=<?php echo CHARSET; ?>" />
<meta name="viewport"
content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;" />
<meta name="apple-mobile-web-app-capable"
         content="yes" />
<meta name="apple-mobile-web-app-status-bar-style"
         content="default" />
         
         
         
         
<div id="google_translate_element"></div><script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'es', includedLanguages: 'de,en,es,fr,it,pt,ru', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
         
         
<?php
if (strpos($PHP_SELF,'checkout') || strpos($PHP_SELF,'shopping_cart') || strpos($PHP_SELF,'account') || strpos($PHP_SELF,'log') || strpos($PHP_SELF,'address') > 0) {
?>         
<meta name="googlebot"
   content="noindex, nofollow">
<meta name="robots"
   content="noindex, nofollow">
<?php
}
?>         
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>" />
<style type="text/css" media="screen">
@import "<?php echo DIR_WS_HTTP_CATALOG . DIR_MOBILE_INCLUDES; ?>iphone.css";
</style>
    <title><?php echo $product_info_name . ' ' . TITLE ?></title>
</head>
<body>
<div id="errorMsg">
<?php
if ($messageStack->size('header') > 0) {
echo $messageStack->output('header');
}
?>
</div>
<link rel="stylesheet" type="text/css" href="ext/jquery/ui/redmond/jquery-ui-1.8.6.css" />
<script type="text/javascript" src="ext/jquery/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="ext/jquery/ui/jquery-ui-1.8.6.min.js"></script>
<script>
$(function() {
$("#search").autocomplete({
                        source: "autocomplete.php",
                        minLength: 2,
                        select: function(event, ui) {
                        }
                });

});
</script>
<!-- header //-->
<div id="header">
<div id="headerLogo"><?php echo '<a href="' . tep_mobile_link(FILENAME_DEFAULT) . '">' . tep_image(DIR_WS_IMAGES . 'store_logo.png', STORE_OWNER, 0,70) . '</a>';?></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="headerNavigation">
  <tr class="headerNavigation">
	<td class="headerNavigation"><a href="<?php echo tep_mobile_link(FILENAME_DEFAULT);?>"><?php echo  tep_image(DIR_MOBILE_IMAGES. "home.png") . "<br>" . TEXT_HOME; ?></a></td>
	<td class="headerNavigation"><a href="<?php echo tep_mobile_link(FILENAME_CATALOG);?>"><?php echo tep_image(DIR_MOBILE_IMAGES. "boutique.png") . "<br>" . TEXT_SHOP; ?></a></td>
	<td class="headerNavigation"><a href="<?php echo tep_mobile_link(FILENAME_MOBILE_ACCOUNT);?>"><?php echo tep_image(DIR_MOBILE_IMAGES. "compte.png") . "<br>" . TEXT_ACCOUNT; ?></a></td>
	<td class="headerNavigation"><a href="<?php echo tep_mobile_link(FILENAME_SEARCH);?>"><?php echo tep_image(DIR_MOBILE_IMAGES. "search2.png") . "<br>" . IMAGE_BUTTON_SEARCH; ?></a></td>
	<td class="headerNavigation"><a href="<?php echo tep_mobile_link(FILENAME_MOBILE_ABOUT);?>"><?php echo tep_image(DIR_MOBILE_IMAGES. "help.png") . "<br>" . TEXT_ABOUT; ?></a></td>
  </tr>
</table>
</div>
<!-- header_eof //-->
<!-- error msg -->
<div id="errorMsg">
<?php
  if (isset($HTTP_GET_VARS['error_message']) && tep_not_null($HTTP_GET_VARS['error_message']))
	echo htmlspecialchars(stripslashes(urldecode($HTTP_GET_VARS['error_message'])));
?>
</div>
<!-- error msg -->
<div id="mainBody">
<?php } 
    if(sizeof($breadcrumb->_trail) > 0)
		$headerTitleText = $breadcrumb->_trail[sizeof($breadcrumb->_trail) - 1]['title'];
  

?>

<?php

      echo '<p align="CENTER" style="margin-top: 0; margin-bottom: 0"><i><b><font size="7" face="Calibri" color="#FF9900">'.'MARKETPLACE'.'</font></b></font></i></p>';


 $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id from " . 'marketplace' . " c, " . 'marketplace_description' . " cd where c.parent_id = '0' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.categories_name");
                    while  ($registros = tep_db_fetch_array($categories_query)){

                    echo '<p align="center" style="margin-top: 0; margin-bottom: 0"><i><b><font size="5" face="Calibri"><a href="mobile_marketplace.php?cPath='.$registros['categories_id'].'">'.$registros['categories_name'].'</a></font></b></i></p>';
                                             }


  ?>
                       </p>

</div><p align="center"><b><font size="6"><a href="<?php echo tep_mobile_link(FILENAME_CATALOG);?>">CATEGORIAS</a></font></b>





<style>
body{
  font-family: Arial;
  padding:20px;
  background:#f4f4f4;
}

.token-container{
  max-width:500px;
  margin-left:0;
  padding:20px;
  background:#fff;
  border:1px solid #ccc;
  border-radius:10px;
}

.top-row{
  display:flex;
  align-items:center;
  gap:10px;
}

label{
  font-weight:bold;
}

.amountInput{
  width:100px;
  margin-left:10px;
}

.buy-btn{
  padding:5px 10px;
  background:#28a745;
  color:#fff;
  border:none;
  border-radius:5px;
  cursor:pointer;
  display:none;
}

.buy-btn:hover{
  background:#218838;
}

.resultToken{
  margin-left:10px;
  font-weight:bold;
}
</style>
</head>
<body>

<div class="token-container">

  <div class="top-row">
    <label for="tokenSelect">Seleccione Token:</label>
    <select id="tokenSelect">
      <option value="">--Seleccione--</option>
    </select>
    <button class="buy-btn" id="buyBtn">Comprar</button>
  </div>

  <div style="margin-top:20px;">
    <label>Importe en EUR:</label>
    <input type="number" class="amountInput" value="<?php ECHO $sumar_hbar_descuentos['value'] ?>">
    <span>Tokens: <span class="resultToken">0</span></span>
  </div>

</div>

<script>
// -------------------- TOKENS --------------------
const tokens = [
  {name:"HBAR", id:"0.0.1456986", link:"https://www.saucerswap.finance/trade/HBAR/0.0.4820413"},
  {name:"USDC", id:"0.0.456858", link:"https://www.saucerswap.finance/trade/HBAR/0.0.456858"},
  {name:"DELICIA ITALIANA", id:"0.0.5310524", link:"https://www.saucerswap.finance/trade/HBAR/0.0.5310524"},
  {name:"Sr.Marihuano", id:"0.0.5341950", link:"https://www.saucerswap.finance/trade/HBAR/0.0.5341950"},
  {name:"SAUCE", id:"0.0.731861", link:"https://www.saucerswap.finance/trade/HBAR/0.0.731861"},
  {name:"PACK", id:"0.0.4794920", link:"https://www.saucerswap.finance/trade/HBAR/0.0.4794920"},
  {name:"DAVINCI", id:"0.0.3706639", link:"https://www.saucerswap.finance/trade/HBAR/0.0.3706639"},
  {name:"KBL", id:"0.0.5989978", link:"https://www.saucerswap.finance/trade/HBAR/0.0.5989978"},
  {name:"ISLAS CANARIAS", id:"0.0.4817159", link:"https://www.saucerswap.finance/trade/HBAR/0.0.4817159"},
  {name:"BTC.H", id:"0.0.9370957", link:"https://www.saucerswap.finance/trade/HBAR/0.0.9370957"}
];

// -------------------- FORMATO --------------------
function formatNumberEU(value, decimals = 6){
  return Number(value).toLocaleString("es-ES", {
    minimumFractionDigits: decimals,
    maximumFractionDigits: decimals
  });
}

// -------------------- SELECT --------------------
const select = document.getElementById("tokenSelect");

tokens.forEach(t=>{
  const option = document.createElement("option");
  option.value = t.id;
  option.textContent = t.name;
  option.dataset.link = t.link;

  // ?? seleccionar HBAR por defecto
  if(t.name.includes("HBAR")){
    option.selected = true;
  }

  select.appendChild(option);
});

// -------------------- FX --------------------
let eurRate = null;

async function loadFX(){
  const res = await fetch("https://api.frankfurter.app/latest?from=USD&to=EUR");
  const data = await res.json();
  eurRate = data.rates.EUR;
}
loadFX();

// -------------------- PRECIO --------------------
async function getTokenPrice(id){
  try{
    const res = await fetch(`/token.php?id=${id}`);
    const data = await res.json();
    return parseFloat(data.priceUsd);
  }catch(err){
    console.error(err);
    return null;
  }
}

// -------------------- ELEMENTOS --------------------
const input = document.querySelector(".amountInput");
const resultEl = document.querySelector(".resultToken");
const buyBtn = document.getElementById("buyBtn");

// -------------------- CALCULAR --------------------
async function calcularTokens(){
  const selectedId = select.value;
  const eur = parseFloat(input.value);

  if(!selectedId || isNaN(eur) || eur <= 0) {
    resultEl.innerText = "0";
    buyBtn.style.display = "none";
    return;
  }

  const priceUSD = await getTokenPrice(selectedId);
  if(!priceUSD || !eurRate){
    resultEl.innerText = "...";
    return;
  }

  const tokensAmount = eur / (priceUSD * eurRate);
  resultEl.innerText = formatNumberEU(tokensAmount,6);

  buyBtn.style.display = tokensAmount > 0 ? "inline-block" : "none";
}

// -------------------- EVENTOS --------------------
input.addEventListener("input", calcularTokens);
select.addEventListener("change", calcularTokens);

// ?? calcular al cargar (HBAR + 5€)
window.addEventListener("load", calcularTokens);

buyBtn.addEventListener("click", ()=>{
  const selectedOption = select.selectedOptions[0];
  if(selectedOption){
    window.open(selectedOption.dataset.link,"_blank","noopener,noreferrer");
  }
});
</script>

</body>
</html>
```

