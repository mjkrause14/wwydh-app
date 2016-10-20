<!DOCTYPE html>
<html>
	<head>
		<title>Contact Us</title>
		<link href="../helpers/header_footer.css" type="text/css" rel="stylesheet" />
		<link href="styles.css" type="text/css" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("li.tablink").click(function() {
                    if (!$(this).hasClass("active")) {
                        // handle nav change
                        $("li.tablink").removeClass("active");
                        $(this).addClass("active");

                        // handle content change
                        $(".tabcontent").removeClass("active");
                        $(".tabcontent[data-tab=" + $(this).data("target") + "]").addClass("active");
                    }
                })
            })
        </script>
	</head>
	<body>
		<div class="width">
			<div id="nav">
				<div class="nav-inner width">
					<a href="../home">
						<div id="logo"></div>
						<div id="logo_name">What Would You Do Here?</div>
					</a>
					<div id="user_nav" class="nav">
						<ul>
							<a href="#"><li>Log in</li></a>
							<a href="#"><li>Sign up</li></a>
						</ul>
					</div>
					<div id="main_nav" class="nav">
						<ul>
							<a href="../locations"><li>Locations</li></a>
							<a href="../ideas"><li>Ideas</li></a>
							<a href="../projects"><li>Projects</li></a>
							<a href="../contact" class="active"><li>Contact</li></a>
						</ul>
					</div>
				</div>
			</div>
		</div>
    <div id="contact">
      <div class="width">
        <div id="contact_name">CONTACT US</div>
            <div id="form">
              <form action="#"> <!--BACKEND: Edit this action to wherever the form will submit to -->
                <input type="text" name="name" class="form-size" placeholder="Name"><br>
                <input type="text" name="email" class="form-size" placeholder="Email"><br>
                <textarea type="text" name="message" class="message" placeholder="Message"></textarea><br>
                <input type="submit" id="submit" class="form-size" value="Submit">
              </form>
            </div>
        </div>
    </div>
    <div id="footer">
            <div class="grid-inner">
                &copy; Copyright WWYDH <?php echo date("Y") ?>
            </div>
    </div>
  </body>
</html>
