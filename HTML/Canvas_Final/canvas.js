//  Author: Alvaro
//  Ultima Modificación: 27 de enero de 2019
var canvas = document.getElementById("myCanvas");
var ctx = canvas.getContext("2d");
var velocidad = 10;

//variables de pelota1
var ballRadius = canvas.height / 30; //radio

//posicion inicial
var x = canvas.width / 2;
var y = canvas.height / 3 + canvas.height / 2;

//movimiento de la bola
var dx = -2;
var dy = -2;

//variables pelota2
var ballRadius2 = canvas.height / 30; //radio
//posicion inicial
var x2 = canvas.width / 2;
var y2 = canvas.height / 3 + canvas.height / 2;
//movimiento bola2
var dx2 = 1;
var dy2 = -1;

//iniciamos variables de pulsacion de teclas
var rightPressed = false;
var leftPressed = false;

//variables de ladrillos
var brickRowCount = 5;
var brickColumnCount = 3;
var brickWidth = 75;
var brickHeight = 20;
var brickPadding = 10;
var brickOffsetTop = 0;
var brickOffsetLeft = 90;
var brickOffsetRight = 30;

//variables de contador de puntos y vidas
var score = 0;
var lives = 3;

//variable posicion de la paleta
var estado = "abajo";

//variables para el sonido a reproducir cuando ganamos
var sonido_victoria = document.createElement('audio');
sonido_victoria.src = "ficheros/win.mp3";

//seleccion de nivel
var nivel = prompt("Seleccione nivel de dificultad del 1 al 3");
switch (nivel) {
    case "1":
        paddleWidth = canvas.width / 4;
        brickColumnCount = 3;
        brickRowCount = 4;
        break;

    case "2":
        canvas.width = 800;
        canvas.height = 500;
        brickColumnCount = 4;
        brickRowCount = 7;
        brickWidth = 80;
        break;

    case "3":
        canvas.width = 900;
        canvas.height = 600;
        brickColumnCount = 7;
        brickRowCount = 9;
        brickWidth = 71;
        velocidad = 20;
        break;

    default:
        paddleWidth = canvas.width / 4;
        brickColumnCount = 3;
        brickRowCount = 4;
        break;
}
//variables paleta 
var paddleHeight = 10;
var paddleWidth = canvas.width / 5;
var paddleX = (canvas.width - paddleWidth) / 2;
var paddley = canvas.height - paddleHeight;
var auxw = paddleWidth;
var auxh = paddleHeight;
var pelotadoble = false;

//opcion de segunda pelota
if(nivel==3){
var opciones = prompt("¿Aumentar el nivel de dificultad? \n Escriba \"s\" para añadir una segunda pelota o \"n\" para una sola pelota.");
switch (opciones) {
    case "s":
        pelotadoble = true;
        break;

    case "n":
        pelotadoble = false;
        break;

    default:
        pelotadoble = false;
        break;
}
}
else{
    pelotadoble=true;
}

var bricks = [];
for (c = 0; c < brickColumnCount; c++) {
    bricks[c] = [];
    for (r = 0; r < brickRowCount; r++) {
        bricks[c][r] = {
            x: 0,
            y: 0,
            status: 1
        };
    }
}

document.addEventListener("keydown", keyDownHandler, false);
document.addEventListener("keyup", keyUpHandler, false);
document.addEventListener("mousemove", mouseMoveHandler, false);

function keyDownHandler(e) {
    if (e.keyCode == 39) {
        rightPressed = true;
    } else if (e.keyCode == 37) {
        leftPressed = true;
    }
}

function keyUpHandler(e) {
    if (e.keyCode == 39) {
        rightPressed = false;
    } else if (e.keyCode == 37) {
        leftPressed = false;
    }
}

function mouseMoveHandler(e) {
    var relativeX = e.clientX - canvas.offsetLeft;
    if (relativeX > 0 && relativeX < canvas.width) {
        paddleX = relativeX - paddleWidth;
    }
}

function collisionDetection() { //comprobar colision de bola con ladrillo
    for (c = 0; c < brickColumnCount; c++) {
        for (r = 0; r < brickRowCount; r++) {
            var b = bricks[c][r];
            //si bolas colisionan
            if (b.status == 1) {
                //bola 1
                if (x > b.x && x < b.x + brickWidth && y > b.y && y < b.y + brickHeight) {
                    dy = -dy;
                    b.status = 0; //borramos ladrillo
                    score++; //aumentamos puntuacion
                }
                //bola2
                if (x2 > b.x && x2 < b.x + brickWidth && y2 > b.y && y2 < b.y + brickHeight) {
                    dy2 = -dy2;
                    b.status = 0; //borramos ladrillo
                    score++; //aumentamos puntuacion
                }
                if (score == brickRowCount * brickColumnCount) { //si puntuacion = al numero de ladrillos
                    sonido_victoria.play(); //reproducimos sonido de victoria
                    alert("YOU WIN, CONGRATS!"); //alert de victoria
                    document.location.reload(); //recargamos
                }
            }
        }
    }
}

function drawBall(pos_x, pos_y, radio) {
    ctx.beginPath();
    ctx.arc(pos_x, pos_y, radio, 0, Math.PI * 2);
    ctx.fillStyle = "blue";
    ctx.fill();
    ctx.closePath();
}
//dibujar paleta
function drawPaddle() {
    ctx.beginPath();
    ctx.rect(paddleX, paddley, paddleWidth, paddleHeight);
    ctx.fillStyle = "blue";
    ctx.fill();
    ctx.closePath();
}
//dibujar ladrillos
function drawBricks() {
    for (c = 0; c < brickColumnCount; c++) {
        for (r = 0; r < brickRowCount; r++) {
            if (bricks[c][r].status == 1) {
                var brickX = (r * (brickWidth + brickPadding)) + brickOffsetLeft;
                var brickY = (c * (brickHeight + brickPadding)) + brickOffsetTop;
                bricks[c][r].x = brickX;
                bricks[c][r].y = brickY;
                ctx.beginPath();
                ctx.rect(brickX, brickY, brickWidth, brickHeight);
                ctx.fillStyle = "blue";
                ctx.fill();
                ctx.closePath();
            }
        }
    }
}
//dibujar puntuacion
function drawScore() {
    ctx.font = "16px Arial";
    ctx.fillStyle = "#0095DD";
    ctx.fillText("Score: " + score, 8, 20);
}
//dibujar vidas
function drawLives() {
    ctx.font = "16px Arial";
    ctx.fillStyle = "#0095DD";
    ctx.fillText("Lives: " + lives, canvas.width - 65, 20);
}
//funcion de repintar la barra para cada lado posible y para reiniciar cuando perdemos una vida 
function repintar(lado) {
    switch (lado) {
        case "derecha": //posicionar lateral derecho
            paddleHeight = auxw;
            paddleWidth = auxh;
            paddleX = canvas.width - paddleWidth;
            paddley = canvas.height - paddleHeight;
            estado = "derecha";
            break;

        case "izquierda": //posicionar lateral izquierdo
            paddleHeight = auxw;
            paddleWidth = auxh;
            paddleX = 0;
            paddley = canvas.height - paddleHeight;
            estado = "izquierda";
            break;

        case "abajo_der": //posicionar esquina inferior derecha
            paddleHeight = auxh;
            paddleWidth = auxw;
            paddleX = canvas.width - paddleWidth;
            paddley = canvas.height - paddleHeight;
            estado = "abajo";
            break;

        case "abajo_izq": //posicionar esquina inferior izquierda
            paddleHeight = auxh;
            paddleWidth = auxw;
            paddleX = 0;
            paddley = canvas.height - paddleHeight;
            estado = "abajo";
            break;

        case "reset": //reiniciar pelotas y barra si perdemos vida
            paddleHeight = auxh;
            paddleWidth = auxw;
            paddleX = (canvas.width - paddleWidth) / 2;
            paddley = canvas.height - paddleHeight;
            estado = "abajo";
            //bola 1
            x = xinicial;
            y = yinicial;
            dx = dxinicial;
            dy = dyinicial;
            //bola2
            x2 = x2inicial;
            y2 = y2inicial;
            dx2 = dx2inicial;
            dy2 = dyinicial;
            break;

        case "loose": //si perdemos
            alert("GAME OVER");
            document.location.reload();
            break;
    }

}
function draw() {
    //ejecucion de las funciones para pintar los ladrillos, las bolas, la paleta, las vidas, la puntuacion y la colision
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    drawBricks();
    drawBall(x, y, ballRadius);//dibujamos la pelota o las pelotas si el usuario ha elegido dos
    if (pelotadoble == true) {
        drawBall(x2, y2, ballRadius2);
        x2 += dx2;
        y2 += dy2;
    }
    drawPaddle();
    drawScore();
    drawLives();
    collisionDetection();

    //rebote de la pelota 1 cuando golpea en los lados
    if (y + dy < ballRadius) {
        dy = -dy;
    } else if (y + dy > canvas.height - ballRadius) {
        if (x > paddleX && x < paddleX + paddleWidth) { //si da en la paleta rebota
            dy = -dy;
        }
        else { //si no perdemos vida
            lives--;
            if (!lives) { //si nos quedamos sin vidas reiniciamos y alert game over (funcion repintar>loose)
                repintar("loose");
            } else {
                repintar("reset");
            }
        }
    }
    //rebote de la pelota 1 cuando golpea abajo
    if (x + dx > canvas.width - ballRadius || x + dx < ballRadius) {
        if (y > paddley && y < paddley + paddleHeight) {//si da en la paleta rebota
            dx = -dx;
        }
        else {  //si no perdemos vida
            lives--;
            if (!lives) { //si nos quedamos sin vidas reiniciamos y alert game over (funcion repintar>loose)
                repintar("loose");
            } else {
                repintar("reset");
            }
        }
    }

    //rebote de la pelota 2 (mismo que el anterior, he intentado meterlo en una funciona y llamarla pero no funciona correctamente)
    if (x2 + dx2 > canvas.width - ballRadius2 || x2 + dx2 < ballRadius2) {
        dx2 = -dx2;
    }
    if (y2 + dy2 < ballRadius2) {
        dy2 = -dy2;
    } else if (y2 + dy2 > canvas.height - ballRadius2) {
        if (x2 > paddleX && x2 < paddleX + paddleWidth) {
            dy2 = -dy2;
        } else {
            lives--;
            if (!lives) {
                repintar("loose"); //si nos quedamos sin vidas reiniciamos y alert game over (funcion repintar>loose)
            } else {
                repintar("reset"); //si la pelota golpea en la parte inferior del canvas repintamos la barra y la 
            }
        }
    }

    //movimiento de la paleta
    if (estado == "abajo") { //estando abajo
        if (rightPressed && paddleX <= canvas.width - paddleWidth && paddleX >= 0) { //si presionamos derecha se mueve a la derecha
            paddleX += velocidad;
        } else if (leftPressed && paddleX <= canvas.width - paddleWidth && paddleX > 0) { //si presionamos izquierda se mueve a la izquierda (en vertical)
            paddleX -= velocidad;
        } else if (rightPressed && paddleX >= canvas.width - paddleWidth) { //si llegamos al limite de la derecha y presionamos derecha repintamos a la derecha
            repintar("derecha");
        } else if (leftPressed && paddleX <= 0) { //si llegamos al limite de la izquierda y presionamos izquierda repintamos a la derecha (en vertical)
            repintar("izquierda");
        }
    } else if (estado == "derecha") { //estando a la derecha 
        if (rightPressed && paddley <= canvas.height - paddleHeight && paddley > 0) { //si presionamos derecha sube
            paddley -= velocidad;
        } else if (leftPressed && paddley < canvas.height - paddleHeight && paddley >= 0) { //si presionamos izquierda baja
            paddley += velocidad;
        } else if (leftPressed && paddley >= canvas.height - paddleHeight) { //si llegamos al limite inferior y presionamos izquierda repintamos la barra abajo en el limite derecho
            repintar("abajo_der");
        }

    } else if (estado == "izquierda") { //estando a la izquierda
        if (rightPressed && paddleX <= 0 && paddley >= 0 && paddley < canvas.height - paddleHeight) { //si presionamos izquierda sube
            paddley += velocidad;
        } else if (leftPressed && paddleX <= 0 && paddley > 0) { //si presionamos derecha baja
            paddley -= velocidad;
        } else if (rightPressed && paddley >= canvas.height - paddleHeight) { //si llegamos al limite inferior y presionamos derecha repintamos la barra abajo en el limite izquierdo
            repintar("abajo_izq");
        }
    }
    x += dx;
    y += dy;

    requestAnimationFrame(draw);
}

draw();