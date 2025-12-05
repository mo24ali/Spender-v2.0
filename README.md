# 💸 Spender – Personal Finance Dashboard (PHP & MySQL)

Spender est une application simple et intuitive permettant aux utilisateurs de gérer leurs **revenus**, leurs **dépenses**, et d'obtenir une **vision claire de leur budget**.  
Développée avec **PHP**, **MySQL**, **HTML/CSS** et un peu de **JavaScript**, cette application constitue un excellent projet pédagogique pour pratiquer les opérations **CRUD**, la gestion des formulaires, et l'organisation d'un mini tableau de bord financier.

---

## 📌 Objectif du projet

Ce projet est la première version d'un outil de gestion financière personnelle destiné à une startup locale.  
L'objectif : fournir une interface simple permettant de :

-   Suivre les revenus
-   Suivre les dépenses
-   Calculer automatiquement le solde disponible
-   Afficher des statistiques financières basiques

---

## 🧱 Fonctionnalités

### 🔹 Revenus (Incomes)
- Afficher tous les revenus
- Ajouter un revenu
- Modifier un revenu
- Supprimer un revenu
- Validation des données

### 🔹 Dépenses (Expenses)
- Afficher toutes les dépenses
- Ajouter une dépense
- Modifier une dépense
- Supprimer une dépense
- Validation des données

### 🔹 Dashboard
- Total des revenus
- Total des dépenses
- Solde = revenus − dépenses
- Vue du mois en cours
- Graphique optionnel (Chart.js)

---

## 🧩 Bonus (optionnel)
- Table **categories** pour classifier revenus/dépenses
- Filtres par catégorie et par date
- Export CSV ou PDF
- Graphique mensuel (Chart.js / Google Charts)
- Système d'authentification (Login / Register)
- Tri des tableaux (montant, date)

---

## 🧪 User Stories

### SQL – Base de données
- Créer la base de données
- Créer les tables `incomes` et `expenses`
- Ajouter les clés primaires
- Définir les bons types SQL (`DECIMAL`, `DATE`, `TEXT`, etc.)
- Ajouter les contraintes (`NOT NULL`, `DEFAULT`, etc.)
- Rassembler tout dans `database.sql`

### CRUD – Incomes
- Afficher les revenus
- Ajouter un revenu via formulaire
- Modifier un revenu
- Supprimer un revenu
- Valider les données

### CRUD – Expenses
- Afficher les dépenses
- Ajouter une dépense via formulaire
- Modifier une dépense
- Supprimer une dépense
- Valider les données

### Dashboard
- Calcul du total des revenus
- Calcul du total des dépenses
- Calcul du solde
- Données du mois courant
- Graphiques simples

---

## 🛠️ Stack Technique

| Technologie         | Utilité                           |
| ------------------- | --------------------------------- |
| **PHP**             | Backend, logique métier           |
| **MySQL**           | Stockage des données              |
| **HTML / CSS**      | Interface utilisateur             |
| **JavaScript**      | Interactivité, graphique          |
| **Chart.js** (optionnel) | Visualisation des données    |
| **XAMPP / WAMP / LAMP** | Environnement serveur       |

---

## 📂 Structure du projet
/Spender
│ ├── /config
│ ├── /models
│ ├── /controllers
│ ├── /views
│ ├── database.sql
│ ├── index.php
│ └── README.md


---

## 🚀 Installation & Setup

### 1️⃣ Cloner le dépôt
```bash
git clone https://github.com/mo24ali/Spender.git


Créer la base de données
Ouvrir phpMyAdmin

Créer une base (ex : spender)

Importer database.sql

Configurer la connexion MySQL
Modifier config/connexion.php :


$host = "localhost";
$user = "root";
$pass = "";
$dbname = "spender";
4️⃣ Lancer le projet
Placer le projet dans htdocs/ (XAMPP) ou www/ (WAMP), puis ouvrir :


http://localhost/Spender/