<!DOCTYPE html>
<html lang="en">
    <head>
        <title>three.js canvas - lines - sphere</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
        <style>
            body {
                background-color: #fff;
                margin: 0px;
                overflow: hidden;
            }
            a {
                color:#0078ff;
            }
            .error-heading {
                position: absolute;
                top: 35%;
                right: 0;
                left: 0;
                text-align: center;
                color: rgba(253, 108, 93, 0.75);
            }
            .error-link {
                position: absolute;
                top: 0;
                right: 0;
                left: 0;
                text-align: center;
                color: rgba(253, 108, 93, 0.75);
                font-size: 16px;
            }
            .error-link:hover, 
            .error-link:focus {
                color: rgba(253, 108, 93, 1);
            }
        </style>
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    </head>
    <body>
        <h1 class="error-heading">شما در اخترک {{ convert('404') }} گم شده‌اید</h1>
        <a class="error-link" href="/">فرار از سیاره نا‌آشنا</a>
        <script src="js/three.min.js"></script>

        <script src="js/Projector.js"></script>
        <script src="js/CanvasRenderer.js"></script>

        <script>
            var SCREEN_WIDTH = window.innerWidth,
            SCREEN_HEIGHT = window.innerHeight,
            mouseX = 0, mouseY = 0,
            windowHalfX = window.innerWidth / 2,
            windowHalfY = window.innerHeight / 2,
            SEPARATION = 20,
            AMOUNTX = 10,
            AMOUNTY = 10,
            camera, scene, renderer;
            init();
            animate();
            function init() {
                var container, separation = 100, amountX = 50, amountY = 50,
                particles, particle;
                container = document.createElement('div');
                document.body.appendChild(container);
                camera = new THREE.PerspectiveCamera( 75, SCREEN_WIDTH / SCREEN_HEIGHT, 1, 10000 );
                camera.position.z = 1000;
                scene = new THREE.Scene();
                scene.background = new THREE.Color( 0xf5f8fa );
                renderer = new THREE.CanvasRenderer();
                renderer.setPixelRatio( window.devicePixelRatio );
                renderer.setSize( SCREEN_WIDTH, SCREEN_HEIGHT );
                container.appendChild( renderer.domElement );
                // particles
                var PI2 = Math.PI * 2;
                var material = new THREE.SpriteCanvasMaterial( {
                    color: 0xfd6c5d,
                    program: function ( context ) {
                        context.beginPath();
                        context.arc( 0, 0, 0.5, 0, PI2, true );
                        context.fill();
                    }
                } );
                for ( var i = 0; i < 5000; i ++ ) {
                    particle = new THREE.Sprite( material );
                    particle.position.x = Math.random() * 2 - 1;
                    particle.position.y = Math.random() * 2 - 1;
                    particle.position.z = Math.random() * 2 - 1;
                    particle.position.normalize();
                    particle.position.multiplyScalar( Math.random() * 10 + 450 );
                    particle.scale.multiplyScalar( 2 );
                    scene.add( particle );
                }
                // lines
                for (var i = 0; i < 1000; i++) {
                    var geometry = new THREE.Geometry();
                    var vertex = new THREE.Vector3( Math.random() * 2 - 1, Math.random() * 2 - 1, Math.random() * 2 - 1 );
                    vertex.normalize();
                    vertex.multiplyScalar( 450 );
                    geometry.vertices.push( vertex );
                    var vertex2 = vertex.clone();
                    vertex2.multiplyScalar( Math.random() * 0.3 + 1 );
                    geometry.vertices.push( vertex2 );
                    var line = new THREE.Line( geometry, new THREE.LineBasicMaterial( { color: 0x8be3cd, opacity: Math.random() } ) );
                    scene.add( line );
                }
                document.addEventListener( 'mousemove', onDocumentMouseMove, false );
                document.addEventListener( 'touchstart', onDocumentTouchStart, false );
                document.addEventListener( 'touchmove', onDocumentTouchMove, false );
                //
                window.addEventListener( 'resize', onWindowResize, false );
            }
            function onWindowResize() {
                windowHalfX = window.innerWidth / 2;
                windowHalfY = window.innerHeight / 2;
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
                renderer.setSize( window.innerWidth, window.innerHeight );
            }
            //
            function onDocumentMouseMove(event) {
                mouseX = event.clientX - windowHalfX;
                mouseY = event.clientY - windowHalfY;
            }
            function onDocumentTouchStart( event ) {
                if ( event.touches.length > 1 ) {
                    event.preventDefault();
                    mouseX = event.touches[ 0 ].pageX - windowHalfX;
                    mouseY = event.touches[ 0 ].pageY - windowHalfY;
                }
            }
            function onDocumentTouchMove( event ) {
                if ( event.touches.length == 1 ) {
                    event.preventDefault();
                    mouseX = event.touches[ 0 ].pageX - windowHalfX;
                    mouseY = event.touches[ 0 ].pageY - windowHalfY;
                }
            }
            //
            function animate() {
                requestAnimationFrame( animate );
                render();
            }
            function render() {
                camera.position.x += ( mouseX - camera.position.x ) * .05;
                camera.position.y += ( - mouseY + 200 - camera.position.y ) * .05;
                camera.lookAt( scene.position );
                renderer.render( scene, camera );
            }
        </script>
    </body>
</html>