# Utilisez une image de base Node.js avec la version souhaitée
FROM node:20-alpine

# Définissez le répertoire de travail dans le conteneur
WORKDIR /app

# Copiez les fichiers de package.json et package-lock.json
COPY package*.json .

# Installez les dépendances
RUN npm install --force

# Copiez le reste des fichiers de l'application
COPY . .

# Construisez l'application React
RUN npm run build

# Exposez le port sur lequel votre application s'exécute (généralement 80 pour une application React)
EXPOSE 5173

# Commande pour exécuter votre application (généralement un serveur web pour servir les fichiers statiques)
CMD ["npm","run","dev"]
