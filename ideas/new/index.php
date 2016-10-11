<?php
    session_start();

    if (isset($_GET["location"])) $location = $_GET["location"];
    else // header("Location: ../");

    if (isset($_GET["idea"])) {
        //BACKEND: handle editing an idea here, EG change title, retrieve entry completion from database and set that pane as active, populate
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>New Idea</title>
		<link href="../../helpers/header_footer.css" type="text/css" rel="stylesheet" />
		<link href="../helpers/splash.css" type="text/css" rel="stylesheet" />
		<link href="styles.css" type="text/css" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<script src="https://use.fontawesome.com/42543b711d.js"></script>
        <script src="scripts.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="width">
			<div id="nav">
				<div class="nav-inner width">
					<a href="../../home">
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
							<a href="../../locations"><li>Locations</li></a>
							<a href="../../ideas" class="active"><li>Ideas</li></a>
							<a href="../../projects"><li>Projects</li></a>
							<a href="../../contact"><li>Contact</li></a>
						</ul>
					</div>
				</div>
			</div>
		</div>
        <div class="outside" class="width">
            <div id="wrapper">
                <div class="pane active" data-index="1">
                    <div class="pane-title">
                        <div class="advance" data-target="2"><i class="fa fa-arrow-right" aria-hidden="true"></i></div>
                        <div class="title">Basic Information</div>
                    </div>
                    <div class="pane-content">
                        <div class="pane-content-intro">Who would lead this project?</div>
                        <div class="button active" data-leader="0">
                            <div>Me</div>
                        </div>
                        <div class="button" data-leader="1">
                            <div>Not Me</div>
                        </div>
                        <div class="login-warning active">This will require an account!</div>
                        <label for="title">Title</label>
                        <input name="title" type="text" placeholder="What is your idea? Be specific!" />
                        <label for="description">Description</label>
                        <textarea name="description" placeholder="Describe your idea in detail."></textarea>
                    </div>
                </div>
                <div class="pane" data-index="2">
                    <div class="pane-title">
                        <div class="advance" data-target="3"><i class="fa fa-arrow-right" aria-hidden="true"></i></div>
                        <div class="retreat" data-target="1"><i class="fa fa-arrow-left" aria-hidden="true"></i></div>
                        <div class="title">Generate Checklist</div>
                    </div>
                    <div class="pane-content">
                        <div class="pane-content-intro">
                            What does your location need to have?
                        </div>
                        <div class="location-checklist">
                            <div class="add-checklist-item"><i class="fa fa-plus" aria-hidden="true"></i> Add item</div>
                            <div class="checklist-item">
                                <input type="text" placeholder="Enter a requirement here. EG: Truck x 4" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pane" data-index="3">
                    <div class="pane-title">
                        <div class="advance" data-target="4"><i class="fa fa-arrow-right" aria-hidden="true"></i></div>
                        <div class="retreat" data-target="2"><i class="fa fa-arrow-left" aria-hidden="true"></i></div>
                        <div class="title">Contributors Needed</div>
                    </div>
                    <div class="pane-content">
                        <div class="pane-content-intro">
                            What contributions do you anticipate needing?
                        </div>
                        <div class="checklist">
                            <div class="add-checklist-item"><i class="fa fa-plus" aria-hidden="true"></i> Add item</div>
                            <div class="checklist-item">
                                <input type="text" placeholder="Enter a location requirement here. EG: Electricity" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pane" data-index="4">
                    <div class="pane-title">
                        <!-- this advance handles completion, that's why the target is -1 -->
                        <div class="advance" data-target="-1"><i class="fa fa-check-circle" aria-hidden="true"></i></div>
                        <div class="retreat" data-target="3"><i class="fa fa-arrow-left" aria-hidden="true"></i></div>
                        <div class="title">Preview</div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
