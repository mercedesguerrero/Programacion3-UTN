
window.addEventListener('load', ()=>{

    document.getElementById('btnTraer').addEventListener('click', TraerTexto());
});

// Queremos traer el texto del servidor y ponerlo en el html
function TraerTexto()
{
    let xhr= new XMLHttpRequest();

    xhr.onreadystatechange= ()=>{ //se lanza cada vez que cambia el readystate (una peticion tiene 5 readystate). Nos interesa la 4, le vamos a asignar un manejador de eventos
        //ACA VA EL CODIGO QUE MANEJA LA PETICION
        let info= document.getElementById('info');
        if(xhr.readyState == 4)//4 es la peticion finalizada
        {
            //lo otro que nos interesa es el status de la peticion, cuando pido algo al servidor y no lo tiene contesta 404, 200 es que la pudo resolver
            if(xhr.status == 200)//salio todo ok
            {
                setTimeout(() => {
                    info.innerText= xhr.responseText;
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
    xhr.open('GET', './documento.txt', true);//abrimos la conexion con el servidor, 
    
    xhr.send();
}