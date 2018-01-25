

// Position de ta lumière 
vec3 lightposition = vec3(10., 30., 5.);


// Vecteur différence
vec3 lightDiff = lightposition - position;

// Plus le vecteur est grand moins la lumière est importante
float distanceFactor = 1. - min(1., length(lightDiff)/40.);

// Produit vectorielle de la position et la source de lumière pour la réflection
float intensity = dot(lightDiff, position);


varying vec4 color = vec4(intensity*distanceFactor, intensity*distanceFactor, intensity*distanceFactor, 1.);




