<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Curriculum Web Service (OMAR)</title>
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

		dl {width:600px;}
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
			<dd><?php echo link_to('classes/comp'); ?></dd>
			<dd><?php echo link_to('classes/comp-110'); ?></dd>
			<dd><?php echo link_to('terms/Fall-2014/classes/comp-110'); ?></dd>

			<dt>Course Classes Taught by Instructor</dt>
			<dd><?php echo link_to('classes?instructor=harry.hellenbrand@csun.edu'); ?></dd>

			<dt>Single Class</dt>
			<dd><?php echo link_to('classes/15223'); ?></dd>

			<dt>Course Listings</dt>
			<dd><?php echo link_to('courses/comp'); ?></dd>
			<dd><?php echo link_to('terms/Fall-2014/courses/comp'); ?></dd>

			<!-- NOT IMPLIMENTED YET 
			<dt>Non-Current Term Classes</dt>
			<dd><a href="http://curriculum.ptg.csun.edu/terms/Fall-2013/classes/">http://curriculum.ptg.csun.edu/terms/Fall-2013/classes/</a></dd>
			<dd><a href="http://curriculum.ptg.csun.edu/terms/Spring-2013/classes/">http://curriculum.ptg.csun.edu/terms/Spring-2013/classes/</a></dd>
			<dd><a href="http://curriculum.ptg.csun.edu/terms/Fall-2014/classes/">http://curriculum.ptg.csun.edu/terms/Fall-2014/classes/</a></dd>
			--> 
		</dl>

	</div>
</body>
</html>
