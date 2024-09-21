const urls = {
    next: '/v1/presentation/active/next/trigger',
    prev: '/v1/presentation/active/prev/trigger'
}
let formData = {
    ip: '',
    port: '',
    passphrase: ''
}


    document.querySelector('#connect').addEventListener('submit', (e) => {
        let response
        e.preventDefault()
        formData.ip = $('input[data-id="ipaddress"]').val()
        formData.port = $('input[data-id="port"]').val()
        formData.passphrase = $('input[data-id="passphrase"]').val()
        response = ajaxCall(formData.ip,formData.port,'credential',formData.passphrase)
        if(response === 'Authorized'){
            document.querySelector('#login').classList.add('hide')
            document.querySelector('#control').classList.remove('hide')
            document.querySelector('.container').classList.add('big')
        }
    })
    document.querySelector('.btn--left').addEventListener('click', () => {
        console.log('prev')
        response = ajaxCall(formData.ip,formData.port,'change','prev')
        console.log(response)
        if(response === 'Authorized'){
            alert('changed')
        }
    })

    document.querySelector('.btn--right').addEventListener('click', () => {
        console.log('next')
        response = ajaxCall(formData.ip,formData.port,'change','next')
        console.log(response)
        if(response === 'Authorized'){
            alert('changed')
        }
    })



function ajaxCall(ip,port,type,content = 'none') {
    try {
        let response
         $.ajax({
            async: false,
            // Our sample url to make request
            url: 'server.php',

            // Type of Request
            type: "POST",
            data: {ip: ip,port: port,type: type,content:content},

            // Function to call when to
            // request is ok
            success: function (data) {
                response = data['error']
            },

            // Error handling
            error: function (error) {
                console.log(`Error ${error}`);
                console.log(error)
            }
        })
        return response

    } catch(error){
        console.log(error)
    }

}
