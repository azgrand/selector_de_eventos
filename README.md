# Selector de Eventos
Selector de eventos en PHP para una URL de datos publis con la puedes crear una sencilla web donde ver los eventos y filtrarlos.


La informacion se puede obtener de: http://opendata.euskadi.eus/catalogo/-/kulturklik-agenda-cultural/ para el ejemplo se usa en su version JSON por lo ligero que es.

El proyecto utiliza como CSS el propio de BoosTrap Min y uno de estilos propios.

Tambien contenemos un fichero sql para crear la bbdd donde alojaremos la tabla que almacenara los datos que recibimos de la url publica anterior.

El fichero api contiene los controles necesrios para la peticion de datos por parte del usuario ( actualmente la peticion se realiza sobre el tipo de evento ) y tambien contiene la opcion poder ser invocada externamente para que actualice periodicamente los datos. Tambien realizara este evento al iniciar la pagina web para cargar nuevos datos y poder filtrarlos.

