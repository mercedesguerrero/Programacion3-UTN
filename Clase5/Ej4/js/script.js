
window.addEventListener('load', ()=>{

    document.forms[0].addEventListener('submit', enviarDatos);
});

// Queremos traer el texto del servidor y ponerlo en el html
function enviarDatos(e)
{
    e.preventDefault();
    let data= traerDatos(e.target);
    let xhr= new XMLHttpRequest();

    xhr.onreadystatechange= ()=>{ //se lanza cada vez que cambia el readystate (una peticion tiene 5 readystate). Nos interesa la 4, le vamos a asignar un manejador de eventos
        //ACA VA EL CODIGO QUE MANEJA LA PETICION
        let info= document.getElementById('info');
        if(xhr.readyState == 4)//4 es la peticion finalizada
        {
            //lo otro que nos interesa es el status de la peticion, cuando pido algo al servidor y no lo tiene contesta 404, 200 es que la pudo resolver
            if(xhr.status == 200)//salio todo ok
            {
                //temporizador- esperar y luego ejecutar una funcion - recibe 2 parametros: callback(funcion) y desp el tiempo
                setTimeout(()=>{
                   
                    info.innerText= xhr.responseText;
                    clearTimeout(tiempo);
                    
                }, 3000);
            }
            else{
                console.log(`Error: ${xhr.status} - ${xhr.statusText}`);
            }
        }
        else{
            info.innerHTML= '<img src="./images/spinner.gif" alt="spinner" />';
        }
    } 
    //3 parámetros: metodo de envio, cuando modificamos usamos POST
    xhr.open('POST', './servidor.php', true);//abrimos la conexion con el servidor, 
    xhr.setRequestHeader('Content-type', 'Application/x-www-form-urlencoded');
    xhr.send(data);//en el post los datos viajan dentro del send

    var tiempo= setTimeout(() => {
        xhr.abort();
        info.innerHTML('Servidor ocupado intente nuevamente');
        
    }, 4000);
}

function traerDatos(form){
    let nombre= form.nombre.value;
    let apellido= form.apellido.value;

    return `nombre=${nombre}&apellido=${apellido}`
}