<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Curriculum Web Service</title>
	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:700);

		body {
			margin:0;
			font-family:'Lato', sans-serif;
			color: #999;
			font-size:14px;
		}

		.welcome {
			position: absolute;
			left: 10px;
			top: 10px;
		}

		a, a:visited {
			text-decoration:none;
		}

		h1 {
			margin: 16px 0 0 0;
		}

		dl {width:700px;}
		dt {font-weight:bold;font-size:16px;margin-top:20px;}
		dd {margin:0;font-weight:normal;}
	</style>
</head>
<body>
	<div class="welcome">
		<h1>Curriculum Web Service (OMAR)</h1>
		<a target="_blank" href="pdfs/CurriculumWebService.pdf">CurriculumWebService.pdf</a>

		<h2>Examples</h2>
		<dl>
			<dt>Course Classes By Subject</dt>
			<dd><?php echo link_to('api/classes/comp'); ?></dd>
			<dd><?php echo link_to('api/classes/comp-110'); ?></dd>
			<dd><?php echo link_to('api/terms/Fall-2014/classes/comp-110'); ?></dd>

			<dt>Course Classes Taught by Instructor</dt>
			<dd><?php echo link_to('api/classes?instructor=harry.hellenbrand@csun.edu'); ?></dd>

			<dt>Single Class</dt>
			<dd><?php echo link_to('api/classes/15223'); ?></dd>

			<dt>Course Listings</dt>
			<dd><?php echo link_to('api/courses/comp'); ?></dd>
			<dd><?php echo link_to('api/terms/Fall-2014/courses/comp'); ?></dd>


			<dt>Non-Current Term Classes</dt>
			<dd><?php echo link_to('api/terms/Fall-2013/classes/comp'); ?></dd>
			<dd><?php echo link_to('api/terms/Spring-2013/classes/comp'); ?></dd>
			<dd><?php echo link_to('api/terms/Fall-2014/classes/comp-322'); ?></dd>
			<dd><?php echo link_to('api/terms/Fall-2014/classes?instructor=steven.fitzgerald@csun.edu'); ?></dd>
		</dl>

	</div>
</body>
</html>
