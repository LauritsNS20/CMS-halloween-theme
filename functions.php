<?php
// theme support

add_theme_support("custom-logo");

add_theme_support("post-thumbnails"); // front images


//register custum widgets

function my_widgets (){
    register_sidebar([
        "name"          => "footer 1",
        "id"            =>  "footer1",
        "before_widget" =>"<div class='widget widget-f1'>",
        "after_widget"  => "</div>",
        "show_in_rest"  => true
    ]);

    register_sidebar([
      "name"          => "footer 2",
      "id"            =>  "footer2",
      "before_widget" =>"<div class='widget widget-f2'>",
      "after_widget"  => "</div>",
      "show_in_rest"  => true
    ]);

    register_sidebar([
       "name"          => "footer 3",
       "id"            =>  "footer3",
       "before_widget" =>"<div class='widget widget-f3'>",
       "after_widget"  => "</div>",
       "show_in_rest"  => true
    ]);

    register_sidebar([
      "name"          => "shortcode widget",
      "id"            =>  "shortcode-widget",
      "before_widget" =>"<div class='widget widget-sw'>",
      "after_widget"  => "</div>",
      "show_in_rest"  => true
   ]);


}

add_action("widgets_init", "my_widgets");

function custom_excerpt_length ($length){
  return 8;
}

add_filter("excerpt_length", "custom_excerpt_length", 999);


//shortcodes

function test_sc () {
  return "have a good halloween";
}

add_shortcode("helloween-test", "test_sc");

function opening_hours(){
    ob_start();
    dynamic_sidebar("shortcode-widget");
    $the_widget = ob_get_contents();
    ob_eng_clean();
    return $the_widget; 
 
}

add_shortcode("halloween-opening", "opening_hours");


//custom posttypes

function staff_members(){
  register_post_type(
    "staffmember", 
    [
          "show_in_rest"        => true,
          "public"              => true,
          "exclude_from_search" => true,
          "has_archive"         => false,
          "labels"              => [
            "name"          => "staff members",
            "singular_name" => "staff member",
            "add_new"       =>  "Tilføj nyt member"
          ],
          "supports"          => [
            "title",
            "editor",
            "thumbnail",
            "custom-fields"
          ]
       ]
    );
  }

  add_action ("init", "staff_members");


  function print_staff_members (){
    ob_start();
    $query = new WP_query(
       [
        "post_staus"    => "publish",
        "order"         => "ASC",
        "post_per_page" => "20",
        "post_type"     => "staffmember"
       ]
    );
    while ($query->have_posts()) {
       $query->the_post();
       the_title("<h3 class='halloween-staff-heading'>", "</h3>");
       the_post_thumbnail("medium");
       ?><div><?php
          the_content();
       ?></div><?php
        $phone = get_post_meta(get_the_id(), 'phone', true);
        $email = get_post_meta(get_the_id(), 'email', true);
        echo "Telefone: ".$phone;
        echo "<br>";
        echo "email: ".$email;

    }
    return ob_get_clean();
  }

  //end of custom posttypes

  add_shortcode("helloween-staff", "print_staff_members");