<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<header>
    <div id="slide-show-wrapper">
    <div id="slide-show">
        <div id="slide-left"> 
            <div id="sliderFrame">
                <div id="slider">
                    <a href="<?php echo base_url(); ?>index.php/plant" target="_blank">
                        <img src="<?php echo base_url(); ?>assests/images/image-slider-1.jpg" alt="Herbal Plant information" />
                    </a>
                    <a href="<?php echo base_url(); ?>index.php/site/about" target="_blank">
                        <img src="<?php echo base_url(); ?>assests/images/image-slider-7.jpg" alt="About Us" />
                    </a>
                    <img src="<?php echo base_url(); ?>assests/images/image-slider-2.jpg" alt="Disease Information" />
                    <img src="<?php echo base_url(); ?>assests/images/image-slider-3.jpg" alt="Disease Diagnosis" />
                    <img src="<?php echo base_url(); ?>assests/images/image-slider-4.jpg" alt="#htmlcaption" />
                    <img src="<?php echo base_url(); ?>assests/images/image-slider-5.jpg" alt="Easy Reports generation"/>
                    <img src="<?php echo base_url(); ?>assests/images/image-slider-6.jpg" alt="Share your Ideas with others"/>
                </div>
                <div id="htmlcaption" style="display: none;">
                    Visit our medical center <a href="<?php echo base_url(); ?>index.php/medical">Click Here...</a>.
                </div>
            </div>
        </div>
        <div id="slide-right">
            <a href="<?php echo base_url(); ?>index.php/plant" class="slide-nav">Herbal Plants</a>
            <a  href="<?php echo base_url(); ?>index.php/disease" class="slide-nav">Disease Information</a>
            <a href="<?php echo base_url(); ?>index.php/diagnosis" class="slide-nav">Disease Diagnosis</a>
            <a href="<?php echo base_url(); ?>index.php/information" class="slide-nav">Medical Information</a>
            <a  href="<?php echo base_url(); ?>index.php/medical" class="slide-nav">Medical Centers</a>
        </div>
    </div>
</div>
</header>
