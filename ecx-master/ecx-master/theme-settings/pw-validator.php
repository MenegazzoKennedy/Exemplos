<?php /* VALIDADOR DE SENHA WORDPRESS ADMIN */
add_action('admin_footer', 'customCSS');

function customCSS() {
  echo '<style>
    #message {
	  display:block;
	  background: #f1f1f1;
	  color: #000;
	  position: relative;
	  padding: 20px;
	  margin-top: 10px;
	}
	#message p {
	  padding: 10px 35px;
	  font-size: 18px;
	}
	.valid {
	  color: green;
	}
	.valid:before {
	  position: relative;
	  left: -35px;
	  content: "✔";
	}
	.invalid {
	  color: red;
	}
	.invalid:before {
	  position: relative;
	  left: -35px;
	  content: "✖";
	}
  </style>';
}

add_action('user_new_form', 'scriptTest');
add_action('show_user_profile', 'scriptTest');
add_action('edit_user_profile', 'scriptTest');
	
function scriptTest() { ?>

	<script>
		jQuery(document).ready(function($) {

			$(".wp-pwd").append('<div id="message"><h3>A senha deve conter os seguintes parâmetros:</h3><p id="letter" class="valid">Uma letra <b>minúscula</b></p><p id="capital" class="valid">Uma letra <b>maiúscula</b></p><p id="number" class="valid">Um <b>numero</b></p><p id="special" class="valid">Um <b>caracter</b> especial</p><p id="length" class="valid">Minimo de <b>8 caracter</b></p></div>');

			var myInput = document.getElementById("pass1");
			var letter = document.getElementById("letter");
			var capital = document.getElementById("capital");
			var number = document.getElementById("number");
			var special = document.getElementById("special");
			var length = document.getElementById("length");

			myInput.onkeyup = function($user_id) {

			  var lowerCaseLetters = /[a-z]/g;
			  if(myInput.value.match(lowerCaseLetters)) {  
			    letter.classList.remove("invalid");
			    letter.classList.add("valid");
			  } else {
			    letter.classList.remove("valid");
			    letter.classList.add("invalid");
			    $('#createusersub').prop("disabled", true);
				$('#submit').prop("disabled", true);
			  }
			  
			  var upperCaseLetters = /[A-Z]/g;
			  if(myInput.value.match(upperCaseLetters)) {  
			    capital.classList.remove("invalid");
			    capital.classList.add("valid");
			  } else {
			    capital.classList.remove("valid");
			    capital.classList.add("invalid");
			    $('#createusersub').prop("disabled", true);
				$('#submit').prop("disabled", true);
			  }

			  var numbers = /[0-9]/g;
			  if(myInput.value.match(numbers)) {  
			    number.classList.remove("invalid");
			    number.classList.add("valid");
			  } else {
			    number.classList.remove("valid");
			    number.classList.add("invalid");
			    $('#createusersub').prop("disabled", true);
				$('#submit').prop("disabled", true);
			  }

			  var specials = /[!@#$%*()_+^&{}}:;?.]/g;
			  if(myInput.value.match(specials)) {  
			    special.classList.remove("invalid");
			    special.classList.add("valid");
			  } else {
			    special.classList.remove("valid");
			    special.classList.add("invalid");
			    $('#createusersub').prop("disabled", true);
				$('#submit').prop("disabled", true);
			  }
			  
			  if(myInput.value.length >= 8) {
			    length.classList.remove("invalid");
			    length.classList.add("valid");
			  } else {
			    length.classList.remove("valid");
			    length.classList.add("invalid");
			    $('#createusersub').prop("disabled", true);
				$('#submit').prop("disabled", true);
			  }
			}

		});

	</script> 

<?php } 

//REGISTRO DA PRIMEIRA SENHA DO USUÁRIO
add_action('user_register', 'save_password_register');

function save_password_register( $user_id ) {

  $actualPW = get_user_meta( $user->ID, 'senha1');

  if ($actualPW[0] == '') {
    $pw1 = md5($_POST['pass1']);
    update_user_meta( $user_id, 'senha1', $pw1 );  
  }
} 

//CRIAÇÃO DO CAMPO QUE GUARDA AS SENHAS
function custom_user_profile_fields($user) { ?>
<table class="form-table">
  <tr>
    <td>
      <input type="hidden" name="senha1" id="senha1" value="<?php echo esc_attr( get_the_author_meta( 'senha1', $user->ID ) ); ?>" class="regular-text" />    

    </td>
  </tr>
  <tr>
    <td>
      <input type="hidden" name="senha2" id="senha2" value="<?php echo esc_attr( get_the_author_meta( 'senha2', $user->ID ) ); ?>" class="regular-text" />    

    </td>
  </tr>
</table>

<?php }

add_action('show_user_profile', 'custom_user_profile_fields');
add_action('edit_user_profile', 'custom_user_profile_fields');
add_action('user_new_form', 'custom_user_profile_fields');

//VALIDAÇÃO DA SENHA
function validateProfileFields( WP_Error $errors, $update, $user ) { 

  $actualPW = get_user_meta( $user->ID, 'senha1');
  $secondPW = get_user_meta( $user->ID, 'senha2');
  $pwToValidate = md5($_POST['pass1']);

  if($actualPW[0] != '' || $secondPW[0] != '') {
    if($actualPW[0] == $pwToValidate || $secondPW[0] == $pwToValidate) {
      $errors->add( 'pass1', "<strong>ERROR Senha</strong>: A senha não pode ser iqual as duas ultimas" );
    } else if ($actualPW[0] != $pwToValidate && $secondPW[0] != $pwToValidate) {
      $secPW = $actualPW[0];
      $actPW = $pwToValidate;
      update_user_meta($user->ID, 'senha1', $actPW);
      update_user_meta($user->ID, 'senha2', $secPW);
    }
  }
}
add_action( 'user_profile_update_errors', 'validateProfileFields', 10, 3 );