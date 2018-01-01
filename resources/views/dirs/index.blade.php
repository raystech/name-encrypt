<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>

    <body>
        <div>
        	<div>

        	</div>
        	<div>
        		<ul>
        		@foreach($files as $file)
        			<li><a href="{{ url('dir/walk/?o='.$walk.'\\'.$file) }}">{{ $file }}</a></li>
        		@endforeach
        		</ul>
        	</div>
            <div>
                <form method="POST" action="">
                    {{csrf_field()}}
                    <input type="hidden" name="dir" value="{{ $dir }}">
                    <label>Prefix: </label>
                    <input type="text" name="prefix">
                    <button type="sumbit">Encrypt</button>
                </form>
            </div>
        </div>
    </body>
</html>