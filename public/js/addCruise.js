window.onload = function (){

    port = document.getElementById('portName');
    addPortBtn = document.getElementById('addPort');
    deletePortBtn = document.getElementById('deletePort');
    portsContainer = document.getElementById('portsContainer');
    
    i=2;
    
    
    addPortBtn.addEventListener('click',function(){
        let clonedPort = port.cloneNode(true);
        clonedPort.name = 'portId'+i;
        portsContainer.append(clonedPort);
        i++;
    })
    
    
    deletePortBtn.addEventListener('click',function(){
        if(i>2){
            portsContainer.removeChild(portsContainer.lastElementChild);
            i--;
        }
    })
    
    }