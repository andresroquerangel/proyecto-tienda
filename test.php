<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const baseURL = 'http://localhost/tienda/administrador/ws/articulos.php';

    // GET Request
    function GET() {
        axios.get(baseURL)
            .then(response => {
                console.log(response.data);
            })
            .catch(error => {
                console.error(error);
            });
    }

    // POST Request
    function NEW() {
        const data = [
            { name: 'NOMBRE', value: 'Coca 222' },
            { name: 'PRECIO', value: '22.0' },
            { name: 'LINEA', value: '907' }
        ];

        axios.post(baseURL, data )
            .then(response => {
                console.log(response.data);
            })
            .catch(error => {
                console.error(error);
            });
    }

    // PUT Request
    function EDIT(id) {
        axios.put(`${baseURL}?id=` + id, {
            data: {
                NOMBRE: 'Coca',
                PRECIO: 22.0,
                LINEA: 907
            }
        })
            .then(response => {
                console.log(response.data);
            })
            .catch(error => {
                console.error(error);
            });
    }

    function DELETE(id) {
        axios.delete(`${baseURL}?id=` + id)
            .then(response => {
                console.log(response.data);
            })
            .catch(error => {
                console.error(error);
            });
    }


    NEW();

</script>