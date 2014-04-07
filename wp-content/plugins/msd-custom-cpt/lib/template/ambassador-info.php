<?php global $wpalchemy_media_access; ?>
<ul class="meta_control">
        <?php $mb->the_field('_bird_species'); ?>
    <li class="odd" id="field_bird_species">
       <label for="<?php $mb->the_name(); ?>">Species</label>
       <div class="input_container">
           <input type="text" tabindex="28" class="medium" value="<?php $mb->the_value(); ?>" 
           id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>">
       </div>
    </li>
    <?php $mb->the_field('_bird_height'); ?>
    <li class="even" id="field_bird_height">
       <label for="<?php $mb->the_name(); ?>">Height</label>
       <div class="input_container">
           <input type="text" tabindex="28" class="small" value="<?php $mb->the_value(); ?>" 
           id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>"> in.
       </div>
    </li>
    <?php $mb->the_field('_bird_weight'); ?>
    <li class="odd" id="field_bird_weight">
       <label for="<?php $mb->the_name(); ?>">Weight</label>
       <div class="input_container">
           <input type="text" tabindex="28" class="small" value="<?php $mb->the_value(); ?>" 
           id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>"> lbs.
       </div>
    </li>
    <?php $mb->the_field('_bird_wingspan'); ?>
    <li class="even" id="field_bird_wingspan">
       <label for="<?php $mb->the_name(); ?>">Wingspan</label>
       <div class="input_container">
           <input type="text" tabindex="28" class="small" value="<?php $mb->the_value(); ?>" 
           id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>"> in.
       </div>
    </li>
    <?php $mb->the_field('_bird_birthdate'); ?>
    <li class="odd" id="field_bird_birthdate">
       <label for="<?php $mb->the_name(); ?>">Birthdate</label>
       <div class="input_container">
           <select class="small" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>">
               <option value="">Select</option>;
               <?php for($y=1980;$y<2030;$y++){
                   print '<option value="'.$y.'"'.$mb->the_select_state($y).'>'.$y.'</option>';
               } ?>
               
           </select>
       </div>
    </li>
    <?php $mb->the_field('_bird_arrived'); ?>
    <li class="even" id="field_bird_arrived">
       <label for="<?php $mb->the_name(); ?>">Arrived at RAPTOR</label>
       <div class="input_container">
           <select class="small" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>">
               <option value="">Select</option>;
               <?php for($y=1980;$y<2030;$y++){
                   print '<option value="'.$y.'"'.$mb->the_select_state($y).'>'.$y.'</option>';
               } ?>
               
           </select>
       </div>
    </li>
</ul>