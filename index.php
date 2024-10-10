<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Site de Films</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Bienvenue sur mon site de films</h1>
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Rechercher un film...">
            <button type="submit">Rechercher</button>
        </form>
        <div id="loader">Chargement...</div> <!-- Loader visible ici -->
    </header>
    
    <section>
        <?php
        // Ta clé API TMDb
        $api_key = '542611a9de55ef5368c5692b1a18936b'; // Remplace par ta clé API réelle

        // Vérifier si une recherche de film a été faite
        if (isset($_GET['search'])) {
            $query = $_GET['search'];
            // URL pour interroger l'API TMDb avec la recherche utilisateur en français
            $url = "https://api.themoviedb.org/3/search/movie?api_key=$api_key&query=" . urlencode($query) . "&language=fr-FR";

            // Récupérer la réponse de l'API
            $response = file_get_contents($url);
            $data = json_decode($response, true);

            // Vérifier si des résultats ont été trouvés
            if (!empty($data['results'])) {
                // Afficher les résultats de la recherche
                echo "<h2>Résultats pour : " . htmlspecialchars($query) . "</h2>";
                foreach ($data['results'] as $film) {
                    echo "<div class='film'>";
                    echo "<h3>" . htmlspecialchars($film['title']) . "</h3>";
                    echo "<p>Date de sortie : " . htmlspecialchars($film['release_date']) . "</p>";
                    echo "<p>Description : " . htmlspecialchars($film['overview']) . "</p>";

                    // Récupérer l'ID du film pour obtenir le trailer
                    $movie_id = $film['id'];
                    $videos_url = "https://api.themoviedb.org/3/movie/$movie_id/videos?api_key=$api_key&language=fr-FR";
                    $videos_response = file_get_contents($videos_url);
                    $videos_data = json_decode($videos_response, true);

                    // Afficher le premier trailer disponible (s'il existe)
                    if (!empty($videos_data['results'])) {
                        $trailer = $videos_data['results'][0];
                        echo '<h4>Trailer</h4>';
                        echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . htmlspecialchars($trailer['key']) . '" frameborder="0" allowfullscreen></iframe>';
                    }

                    // Afficher l'affiche du film (si disponible)
                    if (!empty($film['poster_path'])) {
                        echo "<img src='https://image.tmdb.org/t/p/w200" . htmlspecialchars($film['poster_path']) . "' alt='" . htmlspecialchars($film['title']) . "'>";
                    }
                    echo "</div><hr>";
                }
            } else {
                echo "<p>Aucun film trouvé pour cette recherche.</p>";
            }
        } else {
            echo "<p>Recherchez un film en utilisant la barre ci-dessus.</p>";
        }
        ?>

        <!-- Films à venir -->
        <h2>Films à venir</h2>
        <?php
        $upcoming_url = "https://api.themoviedb.org/3/movie/upcoming?api_key=$api_key&language=fr-FR";
        $upcoming_response = file_get_contents($upcoming_url);
        $upcoming_data = json_decode($upcoming_response, true);

        foreach ($upcoming_data['results'] as $film) {
            echo "<div class='film'>";
            echo "<h3>" . htmlspecialchars($film['title']) . "</h3>";
            echo "<p>Date de sortie : " . htmlspecialchars($film['release_date']) . "</p>";
            if (!empty($film['poster_path'])) {
                echo "<img src='https://image.tmdb.org/t/p/w200" . htmlspecialchars($film['poster_path']) . "' alt='" . htmlspecialchars($film['title']) . "'>";
            }
            echo "</div><hr>";
        }
        ?>

        <!-- Films récemment sortis -->
        <h2>Films récemment sortis</h2>
        <?php
        $recent_url = "https://api.themoviedb.org/3/movie/now_playing?api_key=$api_key&language=fr-FR";
        $recent_response = file_get_contents($recent_url);
        $recent_data = json_decode($recent_response, true);

        foreach ($recent_data['results'] as $film) {
            echo "<div class='film'>";
            echo "<h3>" . htmlspecialchars($film['title']) . "</h3>";
            echo "<p>Date de sortie : " . htmlspecialchars($film['release_date']) . "</p>";
            if (!empty($film['poster_path'])) {
                echo "<img src='https://image.tmdb.org/t/p/w200" . htmlspecialchars($film['poster_path']) . "' alt='" . htmlspecialchars($film['title']) . "'>";
            }
            echo "</div><hr>";
        }
        ?>
    </section>

    <script src="script.js" defer></script>
</body>
</html>
