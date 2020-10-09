      <?php if(isset($this->items) && !empty($this->items)):?>
<style>
.carousel-item .slide-content {
    bottom: 59px;
    position: absolute;
    padding: 10px;
    background: rgba(255,255,255, .7);
    width: 50%;
    text-align: center;
    right: 20px;
}
</style>
<div class="main_banner" >
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
      <?php foreach($this->items as $key=>$item){?>
    <div class="carousel-item <?php if($key==0) echo 'active';?>">
      <img class="d-block w-100" src="<?=asset($item['image_url'])?>" alt="<?=$item['image_url']?>">
        <div class="slide-content"><a class="slide-url" href="<?=$item['url']?>"><?=$item['content']?></a></div>
    </div>
      <?php } ?>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<script type="text/javascript">
      $(document).ready(function(){
          $('.carousel').carousel();
      });
  </script>
</div>
      <?php else: ?>
<!-- Slider Image Not Found -->
      <?php endif; ?>
