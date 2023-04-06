# featuredMedia

[![Release](https://img.shields.io/github/v/release/franck-paul/featuredMedia)](https://github.com/franck-paul/featuredMedia/releases)
[![Date](https://img.shields.io/github/release-date/franck-paul/featuredMedia)](https://github.com/franck-paul/featuredMedia/releases)
[![Issues](https://img.shields.io/github/issues/franck-paul/featuredMedia)](https://github.com/franck-paul/featuredMedia/issues)
[![Dotclear](https://img.shields.io/badge/dotclear-v2.24-blue.svg)](https://fr.dotclear.org/download)
[![Dotaddict](https://img.shields.io/badge/dotaddict-official-green.svg)](https://plugins.dotaddict.org/dc2/details/featuredMedia)
[![License](https://img.shields.io/github/license/franck-paul/featuredMedia)](https://github.com/franck-paul/featuredMedia/blob/master/LICENSE)

---

Ce plugin tire parti d'une possibilité offerte par Dotclear qui permet de définir des médias comme étant liés à des billets, autrement que par le biais des pièces jointes et il est possible de définir une **image à la une** et par extension un média à la une pour un billet ou une page.

La sélection du média à la une (« featured media » en anglais) se fait de la même manière que les pièces jointes pour les billets et les pages, a priori juste dessous les annexes (à droite de la zone d'édition). Une fois le média choisi il apparait de la même façon que les éventuelles annexes.

Pour l'affichage de ce média à la une, il faut utiliser la ou les balises ci-dessous. Voici un exemple de ce qui peut être fait :

```html
<!-- # Featured media -->
<tpl:FeaturedMedia>
  <div class="post-featured-media" id="featured-media {{tpl:FeaturedMediaType}}">
    <tpl:FeaturedMediaIf is_audio="1">
      {{tpl:include src="_audio_player.html"}}
    </tpl:FeaturedMediaIf>
    <tpl:FeaturedMediaIf is_video="1">
      {{tpl:include src="_video_player.html"}}
    </tpl:FeaturedMediaIf>
    <tpl:FeaturedMediaIf is_image="1">
      <img src="{{tpl:FeaturedMediaImageURL size="m"}}" alt="{{tpl:FeaturedMediaTitle}}" />
    </tpl:FeaturedMediaIf>
  </div>
</tpl:FeaturedMedia>
```

Ça permet d'afficher le lecteur audio ou vidéo s'il s'agit respectivement d'un média sonore ou vidéo, sinon d'afficher l'image en taille medium.

## Balises template

La liste des balises template mises à disposition est très similaire à celles utilisées pour les pièces jointes :

### Bloc media à la une `<tpl:FeaturedMedia>`

```html
<tpl:FeaturedMedia>
 …
</tpl:FeaturedMedia>
```

Définit un bloc contenant le média à la une du billet ou de la page s'il est spécifié. Cette balise est obligatoire.

### Bloc de test `<tpl:FeaturedMediaIf>`

```html
<tpl:FeaturedMediaIf [operator="…"] [condition 1] [condition 2] … >
 …
</tpl:FeatureMediaIf>
```

Avec les attributs suivants :

* `operator="&&"` [1] (défaut) ou `operator="||"` [2] : combine les conditions avec un et logique (toutes les conditions vraies valident l'ensemble, par défaut) ou un ou logique (au moins une des conditions vraies valide l'ensemble)
* `is_image="0"` ou `is_image="1"` : teste si le média est une image
* `has_thumb="0"` ou `has_thumb="1"` : teste si le média a une miniature carrée (square)
* `has_size="sq|t|s|m|…"` : teste si le média à une miniature de la taille demandée
* `is_audio="0"` ou `is_audio="1"` : teste si le média est un fichier sonore
* `is_video="0"` ou `is_video="1"` : teste si le média est un fichier vidéo
* `is_mp3="0"` ou `is_mp3="1"` : teste si le média est un fichier audio mp3
* `is_flv="0"` ou `is_flv="1"` : teste si le média est un fichier vidéo flv (déprécié)

Vous pouvez si besoin utiliser une balise `{{tpl:else}}` à l'intérieur du bloc pour traiter le cas où la condition n'est pas validée.

L'exemple en début de billet montre l'usage possible de certains de ces tests.

### Valeur {{tpl:FeaturedMediaMimeType}}

Retourne le mime-type du média.

### Valeur {{tpl:featuredMediaType}}

Retourne le type de média ("video", "image", "audio", …).

### Valeur {{tpl:featuredMediaFileName}}

Retourne le nom du fichier média.

### Valeur {{tpl:featuredMediaSize [full="1"] }}

Retourne la taille du fichier média. Si l'attribut full="1" est spécifié alors la taille est retournée sous forme lisible (Ko, Mo, Go, …).

### Valeur {{tpl:featuredMediaTitle}}

Retourne le titre du média.

### Valeur {{tpl:featuredMediaThumbnailURL}}

Retourne l'URL de la miniature carrée (square) du média, si elle existe.

### Valeur {{tpl:featuredMediaImageURL [size="…"] }}

Retourne l'URL de la miniature à la taille demandée (sq, t, s, m, …), si size="…" est spécifié et si elle existe, sinon l'URL du média original.

### Valeur {{tpl:featuredMediaURL}}

Retourne l'URL du média.

### Condition has_featured_media pour la balise `<tpl:EntryIf>`

Une nouvelle condition est ajoutée à la balise `<tpl:EntryIf>` qui permet de tester si l'entrée à un média à la une ou pas :

has_featured_media="0" ou has_featured_media="1"
Exemple :

```html
<tpl:EntryIf has_featured_media="1">
 …
</tpl:Entry>
```

### Notes

[1] Vous pouvez utiliser and à la place de && si vous préférez.

[2] Vous pouvez utiliser or à la place de || si vous préférez.
