<h3>Résultat recherche <?php if(is_string($query)) echo "\"".$query."\""; ?></h3>
<ul>

<?php
    if($resultats["podcasts"]) {
        $nb_podcasts = count($resultats["podcasts"]);
        echo "<li> ".$nb_podcasts." podcast".($nb_podcasts > 1 ? "s": "")." : <br/>";
        foreach ($resultats["podcasts"] as $podcast) {
            if($podcast->tags)
            {
                $display_tags = "";
                $tags = json_decode($podcast->tags);
                foreach($tags as $tag)
                {
                    $display_tags .= "<span class='badge badge-primary'>".$tag->value."</span>&nbsp;";
                }
            }
            echo '
                <a href="'.site_url("podcasts/display/".$podcast->id).'">
                '.(is_string($query) ? str_replace($query, "<b>".$query."</b>",$podcast->titre) : $podcast->titre).'
                </a> : 
                '.(is_string($query) ? str_replace($query, "<b>".$query."</b>",$podcast->description) : $podcast->description).
                ($display_tags ? " - ".$display_tags : "").
                '<br/>';
        }

        echo "</li>";
    }
    if($resultats["episodes"]) {
        $nb_episodes = count($resultats["episodes"], COUNT_RECURSIVE) - count(array_keys($resultats["episodes"]));
        echo "<li> ".$nb_episodes." épisode".($nb_episodes > 1 ? "s": "")." : <br/>";
        foreach ($resultats["episodes"] as $id_podcast => $liste_episodes) {
            echo '
                <a href="'.site_url("podcasts/display/".$id_podcast).'">
                '.(is_string($query) ? str_replace($query, "<b>".$query."</b>",current($liste_episodes)->podcast_titre) : current($liste_episodes)->podcast_titre).'
                </a>';
            echo '<br/><ul>';
            foreach($liste_episodes as $episode_podcast)
            {
                $display_tags = "";
                if($episode_podcast->tags)
                {
                    $tags = json_decode($episode_podcast->tags);
                    foreach($tags as $tag)
                    {
                        $display_tags .= "<span class='badge badge-primary'>".$tag->value."</span>&nbsp;";
                    }
                }
                $episode_description = substr(strip_tags($episode_podcast->description), 0,200).(strlen($episode_podcast->description) > 200 ? '...' : '');
                echo '
                    <li> 
                        <a href="'.site_url("episodes/view/".$episode_podcast->id).'">'.(is_string($query) ? str_replace($query, "<b>".$query."</b>",$episode_podcast->titre) : $episode_podcast->titre) .'</a>
                        <br/>
                        '.(is_string($query) ? str_replace($query, "<b>".$query."</b>",$episode_description) : $episode_description).
                        ($display_tags ? " - ".$display_tags : "").'
                    </li>';
            }
            echo '</ul>';
        }
        echo "</li>";
    }
    echo "</ul>";
?>
</ul>
