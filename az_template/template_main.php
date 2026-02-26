<?php
/*
  $Id: template_main.php,v 1.0 17:37:59 06/17/2009  

  Mian template class for AlgoZone AFTS templates

  Copyright (c) 2009 AlgoZone, Inc (www.algozone.com)

*/

//Include for template files
$tmpl_id = 'OSC2310002';
require_once('mapping/vars_map.php');

//Build hheader/footer/columns on the include of this file and store it for future use
ob_start(); 
// Collection of css included to the template.
// template_styles.css - Template Specific CSS
//#### HEADER CSS #########

?>
    <link rel="stylesheet" type="text/css" href="<?php echo  TMPL_CSS ?>template_styles.css" />
    <!--[if lt IE 8 ]><link rel="stylesheet" type="text/css" href="<?php echo  TMPL_CSS ?>template_styles_ie.css" /><![endif]-->    
    <link rel="stylesheet" type="text/css" href="<?php echo  TMPL_CSS ?>cart_styles.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  TMPL_CSS ?>intro_boxes_styles.css" />
	
<!--[if lte IE 6]>
<style type="text/css">
 	img, .topbox_sep, .content_mid, 
	.az-button-left, .azbutton_left, .az-button-right, .azbutton_right, 
	.az-button-left2, .azbutton_left2, .az-button-right2, .azbutton_right2, 
	.az-button-left3, .azbutton_left3, .az-button-right3, .azbutton_right3 {
		behavior: url(<?php echo  TMPL_CSS ?>iepngfix.htc);
	}
</style>
<![endif]-->

<!--[if IE 8]>
<style type="text/css">
 	.min_height_ie8{ min-height:507px}
 	.min_height_normal{ min-height:335px}
</style>
<![endif]-->

 <!--[if IE 9]>
<style type="text/css">
 	.buttonSet {
    padding-top: 10px;
}
</style>
<![endif]-->
   
<?php
//#### END HEADER CSS #########
$az_html['css'] = ob_get_contents(); 
ob_end_clean();

ob_start(); 
?>
<?php
$az_html['js'] = ob_get_contents(); 
ob_end_clean(); 

ob_start(); 
// HTML Code for the header of the template
//#### HEADER HTML #########
?>
 
 

 
 
<div class="wrapper <?php echo ($tmpl['cfg']['main_page'] ? 'main_page' : 'default_page'); ?> " align="center">
	  	
	<div class="az_main_container">
				
		<div class="f_left header_store_name"><?php include(TMPL_BOXES . 'az_logo_box.php');?></div>
  


			<!--header_boxes-->
			<div class="f_right header_boxes">

							<?php include(TMPL_BOXES . 'az_shopping_cart.php');?>
							<div class="f_right header_box_lang"><?php require(TMPL_BOXES . 'az_languages.php'); ?></div>
							<div class="f_right header_box_currencies"><?php require(TMPL_BOXES . 'az_currencies.php'); ?></div>

							<div class="f_right header_box_search"><?php include(TMPL_BOXES . 'az_search.php');?></div>
       
 <?php
                            if (DESCUENTO_CLIENTE){

                             $sumar_ofertas_sales_raw = "select sum(products_descuento_onoff) as value, count(*) as products_descuento_onoff from " . TABLE_PRODUCTS . " where products_descuento_onoff = 1 and products_status = 1";
    $sumar_ofertas_sales_query = tep_db_query($sumar_ofertas_sales_raw);
    $sumar_ofertas= tep_db_fetch_array($sumar_ofertas_sales_query);
echo '<b>Descuento del ' . DESCUENTO_CLIENTE . '% en '.$sumar_ofertas['value'].' Productos</b>';
                                               }


             ?>

							<!--menu-->
							<div class="f_right">
								<ul class="topmenu">
									<li><a href="<?php echo $tmpl['url']['loginout'] ?>"><?php echo $tmpl['txt']['loginout'] ?></a></li>
									<li><a href="<?php echo $tmpl['url']['checkout'] ?>"><?php echo $tmpl['txt']['checkout'] ?></a></li>
									<li><a href="<?php echo $tmpl['url']['cart'] ?>"><?php echo 'Carrito de Compras' ?></a></li>
									<li><a href="<?php echo $tmpl['url']['create_account'] ?>"><?php echo $tmpl['txt']['create_account'] ?></a></li>
					                  <li><a href="<?php echo $tmpl['url']['specials'] ?>"><?php echo $tmpl['txt']['specials'] ?></a></li>
									<li><a href="<?php echo '/product_info.php?products_id=1348&cPath=21' ?>"> Comprar USDT </a></li>
									<li><a href="<?php echo '/product_info.php?products_id=1347&cPath=21' ?>"> Vender  USDT</a></li>
									</ul>
							</div>
							<!--menu-->
							<div class="clear"></div>
					
			</div>
						
			<!--header_boxes-->
			<div class="clear"></div>
							   
			<!--categ-->
			<?php require(TMPL_BOXES . 'az_categories.php'); ?>
			<!--categ-->
			
			<?php if ( $tmpl['cfg']['main_page'] ) { 
		//	require(TMPL_BOXES . 'az_slider.php');
		//	require(TMPL_BOXES . 'az_slider_new_products.php');


           }



             ?><!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Carrusel Tokens</title>
<style>
body{
  font-family: Arial;
  padding:20px;
  background:#f4f4f4;
}

.carousel-container{
  width:100%;
  max-width:1200px;
  margin:auto;
  overflow-x:auto;
  border:1px solid #ccc;
  border-radius:10px;
  background:#fff;
  position:relative;
  cursor:grab;
  overscroll-behavior: contain;
  -webkit-overflow-scrolling: auto;
}

.carousel-track{
  display:flex;
  white-space:nowrap;
}

.carousel-item{
  flex:0 0 auto;
  padding:20px;
  font-size:18px;
  font-weight:bold;
  border-right:1px solid #eee;
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

.carousel-footer{
  margin-top:20px;
  font-size:14px;
  color:#333;
}
</style>
</head>
<body>

<div class="carousel-container" id="carouselContainer">
  <div class="carousel-track" id="carouselTrack"></div>
</div>

<div class="carousel-footer">
  Pague aqui con USDC y Reclame sus descuentos en criptomonedas de la red de Hedera, consulte al responsable de la empresa
</div>

<div style="display:flex; align-items:center; gap:12px; white-space:nowrap; overflow-x:auto; margin-top:20px;">
  <a href="https://marketplace2024.blogspot.com/2026/01/pagina-de-inicio.html"
     style="background: rgb(245,124,0); border-radius:5px; color:white; font-size:14px; font-weight:600; padding:8px 14px; text-decoration:none;">
      Seleccione nueva meme
  </a>

  <strong style="font-size:16px; color:black;">Descargar Wallet:</strong>

  <a href="https://www.hashpack.app/download"
     style="background: rgb(46,125,50); border-radius:5px; color:white; font-size:13px; font-weight:600; padding:8px 14px; text-decoration:none;">
      HashPack
  </a>

  <a href="https://www.kabila.app/wallet"
     style="background: rgb(106,27,154); border-radius:5px; color:white; font-size:13px; font-weight:600; padding:8px 14px; text-decoration:none;">
      Kabila
  </a>

  <a href="https://www.saucerswap.finance/saucerswap-wallet"
     style="background: rgb(2,119,189); border-radius:5px; color:white; font-size:13px; font-weight:600; padding:8px 14px; text-decoration:none;">
      SaucerWallet
  </a>

  <a href="https://marketplace2024.blogspot.com/2026/01/comercios-y-empresas.html"
     target="_blank"
     style="background: rgb(106,27,154); border-radius:5px; color:white; font-size:13px; font-weight:600; padding:8px 14px; text-decoration:none;">
      Manual ProInsalacion
  </a>
</div>

<script>
// -------------------- CONFIG --------------------
const carouselContainer = document.getElementById("carouselContainer");
const track = document.getElementById("carouselTrack");

// Tokens
const tokens = [
  {name:"RED HEDERA HASHGRAPH HBAR", id:"0.0.1456986", el:"priceHBAR", link:"https://www.saucerswap.finance/trade/HBAR/0.0.4820413"},
  {name:"USDC", id:"0.0.456858", link:"https://www.saucerswap.finance/trade/HBAR/0.0.456858"},
  {name:"DELICIA ITALIANA", id:"0.0.5310524", el:"priceDLI", link:"https://www.saucerswap.finance/trade/HBAR/0.0.5310524"},
  {name:"Sr.Marihuano", id:"0.0.5341950", el:"priceSRM", link:"https://www.saucerswap.finance/trade/HBAR/0.0.5341950"},
  {name:"SAUCE", id:"0.0.731861", el:"priceSAUCE", link:"https://www.saucerswap.finance/trade/HBAR/0.0.731861"},
  {name:"PACK", id:"0.0.4794920", el:"pricePACK", link:"https://www.saucerswap.finance/trade/HBAR/0.0.4794920"},
  {name:"DAVINCI", id:"0.0.3706639", el:"priceDAVINCI", link:"https://www.saucerswap.finance/trade/HBAR/0.0.3706639"},
  {name:"KBL", id:"0.0.5989978", el:"priceKBL", link:"https://www.saucerswap.finance/trade/HBAR/0.0.5989978"},
  {name:"ISLAS CANARIAS", id:"0.0.4817159", el:"priceISLAS", link:"https://www.saucerswap.finance/trade/HBAR/0.0.4817159"},
  {name:"BTC.H", id:"0.0.9370957", el:"priceBITCOIN", link:"https://www.saucerswap.finance/trade/HBAR/0.0.9370957"}
];

// -------------------- FUNCIONES --------------------
// Formato número europeo
function formatNumberEU(value, decimals = 6){
  return Number(value).toLocaleString("es-ES", {
    minimumFractionDigits: decimals,
    maximumFractionDigits: decimals
  });
}

// Crear items
tokens.forEach(t=>{
  const item = document.createElement("div");
  item.className="carousel-item";
  item.innerHTML=`
    <div style="margin-bottom:10px;">
      <strong>${t.name}</strong>: <span id="${t.el}">Cargando...</span>
      <button class="buy-btn" data-link="${t.link}">Comprar</button>
    </div>
    <div style="margin-top:10px; font-size:14px;">
      <label>Importe en Eur:</label>
      <input type="number" class="amountInput" placeholder="0" style="width:80px; margin-left:5px;">
      <span style="margin-left:10px;">Tokens: <span class="resultToken">0</span></span>
    </div>
  `;
  track.appendChild(item);
});

// Duplicado para loop
tokens.forEach(t=>{
  const item = document.createElement("div");
  item.className="carousel-item";
  item.innerHTML=`
    <div style="margin-bottom:10px;">
      <strong>${t.name}</strong>: ---
      <button class="buy-btn" data-link="${t.link}">Comprar</button>
    </div>
    <div style="margin-top:10px; font-size:14px;">
      <label>Importe en Eur:</label>
      <input type="number" class="amountInput" placeholder="0" style="width:80px; margin-left:5px;">
      <span style="margin-left:10px;">Tokens: <span class="resultToken">0</span></span>
    </div>
  `;
  track.appendChild(item);
});

// -------------------- SCROLL AUTOMÁTICO --------------------
let scrollSpeed = 0.5;
let isHovering = false;

carouselContainer.addEventListener("mouseenter", ()=> isHovering = true);
carouselContainer.addEventListener("mouseleave", ()=> isHovering = false);

function autoScroll(){
  if(!isHovering){
    carouselContainer.scrollLeft += scrollSpeed;
    if(carouselContainer.scrollLeft >= track.scrollWidth/2){
      carouselContainer.scrollLeft = 0;
    }
  }
  requestAnimationFrame(autoScroll);
}
autoScroll();

// -------------------- DRAG (ARRASTRAR CON MOUSE) --------------------
let isDragging = false;
let startX;
let scrollLeft;

carouselContainer.addEventListener("mousedown", e=>{
  isDragging = true;
  startX = e.pageX - carouselContainer.offsetLeft;
  scrollLeft = carouselContainer.scrollLeft;
  carouselContainer.style.cursor = "grabbing";
});

carouselContainer.addEventListener("mouseleave", ()=>{
  isDragging = false;
  carouselContainer.style.cursor = "grab";
});

carouselContainer.addEventListener("mouseup", ()=>{
  isDragging = false;
  carouselContainer.style.cursor = "grab";
});

carouselContainer.addEventListener("mousemove", e=>{
  if(!isDragging) return;
  e.preventDefault();
  const x = e.pageX - carouselContainer.offsetLeft;
  const walk = (x - startX) * 2; // multiplicador de velocidad
  carouselContainer.scrollLeft = scrollLeft - walk;
});

// -------------------- COMPRAR --------------------
document.addEventListener("click", e=>{
  if(e.target.classList.contains("buy-btn")){
    window.open(e.target.dataset.link, "_blank", "noopener,noreferrer");
  }
});

// -------------------- CARGAR PRECIOS --------------------
async function loadPrices(){
  await Promise.all(tokens.map(async t=>{
    try{
      const res=await fetch(`token.php?id=${t.id}`);
      const data=await res.json();
      const el=document.getElementById(t.el);
      if(el) el.innerText = data.priceUsd ? "$"+data.priceUsd : "N/A";
    }catch(err){ console.error(err); }
  }));
}
loadPrices();
setInterval(loadPrices,60000);

// -------------------- CÁLCULO € -> TOKENS --------------------
let eurRate = null;
async function loadFX(){
  const res = await fetch("https://api.frankfurter.app/latest?from=USD&to=EUR");
  const data = await res.json();
  eurRate = data.rates.EUR;
}
loadFX();
setInterval(loadFX,600000); // cada 10 min

async function calcularTokens(item, token){
  const input = item.querySelector(".amountInput");
  const resultEl = item.querySelector(".resultToken");
  const amountEUR = parseFloat(input.value);

  if(isNaN(amountEUR)){
    resultEl.innerText = "0";
    return;
  }

  try{
    const resToken = await fetch(`token.php?id=${token.id}`);
    const dataToken = await resToken.json();
    const priceUSD = parseFloat(dataToken.priceUsd);

    if(!eurRate){
      resultEl.innerText = "...";
      return;
    }

    const tokensAmount = amountEUR / (priceUSD * eurRate);
    resultEl.innerText = formatNumberEU(tokensAmount,6);

  }catch(err){
    console.error(err);
    resultEl.innerText = "Error";
  }
}

// Eventos input
document.querySelectorAll(".carousel-item").forEach((item, index)=>{
  const token = tokens[index % tokens.length];
  const input = item.querySelector(".amountInput");
  input.addEventListener("input", ()=> calcularTokens(item, token));
});
</script>
</body>
</html>


               <?php


      if ( !$tmpl['cfg']['main_page'] ) { ?><div class="space_4">&nbsp;</div> <?php } ?>
						   
	</div>
			 
      <div class="az_main_container">
		<div class="az_wrapper_color">	
	  
		<div class="space_3">&nbsp;</div>
<?php
//#### END HEADER HTML #########
$az_html['header'] = ob_get_contents();
ob_end_clean(); 

ob_start(); 
// HTML Code for the footer of the template
//#### FOOTER HTML #########
?>
		
		
		
		</div>
		
		
		
	<!-- class="az_main_container" -->
		</div>
		
		<!-- footer //-->
		<div class="footer_box">
			<div class="footer_width_pad"><?php require(TMPL_BOXES . 'az_information_footer.php'); ?></div>
		</div>
		<div align="left" class="footer_copyright"><?php echo $tmpl['txt']['copyright'] ?></div>
		<!-- footer //-->

		</div>

    	

	

<?php include(TMPL_BOXES . 'az_socials.php');?>


<?php
//#### END FOOTER HTML #########
$az_html['footer'] = ob_get_contents(); 
ob_end_clean(); 

ob_start(); 
// HTML Code for the main content section of the template, top part
//#### CONTENT TOP HTML #########
?>
		<div class="az_main_content">
		
			
				<?php if ( !$tmpl['cfg']['main_page'] ) { ?>
				<!-- class="az_left_bar -->
				<div class="az_left_bar col-left side-col">
					<div class="az_left_bar_inner">	
						<!-- left_navigation //-->
						<?php require(TMPL_INC_DIR . 'az_tmpl_column_left.php'); ?>
						<!-- left_navigation_eof //-->
  				<div class="main_part_title"><?php// echo BOX_TAGS; ?></div>

						<?php// require(TMPL_BOXES . 'az_flash.php'); ?>
					</div>
				</div>
				<!-- class="az_left_bar -->
				<?php } ?>
			
			<div class="az_site_content">

				<div class="az_site_content_inner">
				<?php if (!$tmpl['cfg']['main_page'] ) {require(TMPL_BOXES . 'az_bread_crumbs.php');} ?>
				
	<?php
	//#### END CONTENT TOP HTML #########
	$az_html['content_top'] = ob_get_contents(); 
	ob_end_clean(); 
	
	ob_start(); 
	// HTML Code for the main content section of the template, bottom part
	//#### CONTENT BOTTOM HTML #########
	?>
							
				<div class="clear"></div>
							
				</div>
			</div>
			
			
			
			<!-- class="az_site_content" -->
			
			
		   <div class="clear"></div>
		</div>
		<!-- class="az_main_content" -->
<?php
//#### END CONTENT BOTTOM HTML #########
$az_html['content_bot'] = ob_get_contents(); 
ob_end_clean(); 

$GLOBALS['az_html'] = $az_html;
if (!class_exists('azTmpl', false)) {
    class azTmpl {
    
    	// class constructor
		function azTmpl($html='', $direct_output = false) {
			if(empty($html)) {
				$this->html = $GLOBALS['az_html'];
			} else {
				$this->html = $html;
			}
		}    
		
    	function az_tmpl_css () {
    		echo $this->html['css'];
    	}
    
    	function az_tmpl_js () {
    		echo $this->html['js'];
    	}
    	
    	function az_tmpl_header () {
    		echo $this->html['header'];
    	}
    	
    	function az_tmpl_footer () {
    		echo $this->html['footer'];
    	}
    	
    	function az_tmpl_content_top () {
    		echo $this->html['content_top'];
    	}
    	
    	function az_tmpl_content_bottom () {
    		echo $this->html['content_bot'];
    	}
    	
    }
}
?>
