// Calcul de l'URL
function getUrl(method, forWeather, city_id, weather_id){
    var url = './cities';
    switch(method){
        case 'get' : 
            if (forWeather) {
                url += '/:' + city_id + "/weather";
            }
            break;
        case 'post' :
            if (forWeather) {
                url += '/:' + city_id + "/weather";
            }
            break;
        case 'delete' :
            url += '/:' + city_id;
            if (forWeather) {
                url += '/:' + city_id + "/weather/:" + weather_id;
            }
            break;
        default:
            break;
    }
    return url;
}

// Appel de l'api
async function callApi(method, forWeather){
    url = getUrl(method, forWeather);
    
    await axios({method: method,url: url})
      .then(function (response) {
            // Récupération des données
            return response;
        })
        .catch(function (error) {
            // Log Erreur
            console.log(error);
        });
}


// Affichage de toutes les villes sur le bandeau gauche

cities = callApi('get', false);



for (city in cities){
    console.log(city[0]);
}


// Affichage des conditiosn météorologique sur le panneau principal 


