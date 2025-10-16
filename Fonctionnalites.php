<?php
// features.php
include 'includes/config.php';
include 'includes/header.php';
?>

<main class="bg-gradient-to-b from-blue-50 to-indigo-50">
  <!-- Hero Section -->
  <section class="relative py-20 overflow-hidden">
    <div class="container mx-auto px-4">
      <div class="max-w-3xl mx-auto text-center">
        <span class="inline-block py-1 px-3 mb-4 text-xs font-semibold text-blue-600 bg-blue-100 rounded-full">POUR LES ÉTUDIANTS</span>
        <h1 class="mb-6 text-4xl md:text-5xl lg:text-6xl font-bold font-heading animate-fadeIn">
          Des fonctionnalités <span class="text-blue-600">puissantes</span>,<br>
          <span class="text-blue-600">gratuites</span> pour les étudiants
        </h1>
        <p class="mb-8 text-lg text-gray-600 leading-relaxed">
          Kotaybi offre aux étudiants tous les outils nécessaires pour gérer leurs courses en colocation,
          sans aucun frais. Découvrez comment nous simplifions votre vie quotidienne.
        </p>
      </div>
    </div>
  </section>

  <!-- Features Grid -->
  <section class="py-20">
    <div class="container mx-auto px-4">
      <div class="flex flex-wrap -mx-4 -mb-8">
        <!-- Feature 1 -->
        <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8 wow fadeInUp" data-wow-delay=".1s">
          <div class="p-8 bg-white rounded-xl shadow-lg h-full transform transition duration-500 hover:scale-105">
            <div class="mb-6 w-16 h-16 mx-auto flex items-center justify-center bg-blue-100 rounded-xl text-blue-600">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
              </svg>
            </div>
            <h3 class="mb-3 text-xl font-bold text-center">Partage facile</h3>
            <p class="text-gray-600 text-center">
              Partagez vos listes avec vos colocataires en un clic. Chacun peut ajouter ou cocher des produits en temps réel.
            </p>
          </div>
        </div>

        <!-- Feature 2 -->
        <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8 wow fadeInUp" data-wow-delay=".2s">
          <div class="p-8 bg-white rounded-xl shadow-lg h-full transform transition duration-500 hover:scale-105">
            <div class="mb-6 w-16 h-16 mx-auto flex items-center justify-center bg-blue-100 rounded-xl text-blue-600">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
              </svg>
            </div>
            <h3 class="mb-3 text-xl font-bold text-center">Listes intelligentes</h3>
            <p class="text-gray-600 text-center">
              Catégorisez automatiquement vos produits (fruits, légumes, produits laitiers...) pour des courses organisées.
            </p>
          </div>
        </div>

        <!-- Feature 3 -->
        <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8 wow fadeInUp" data-wow-delay=".3s">
          <div class="p-8 bg-white rounded-xl shadow-lg h-full transform transition duration-500 hover:scale-105">
            <div class="mb-6 w-16 h-16 mx-auto flex items-center justify-center bg-blue-100 rounded-xl text-blue-600">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
            </div>
            <h3 class="mb-3 text-xl font-bold text-center">Historique</h3>
            <p class="text-gray-600 text-center">
              Conservez l'historique de vos listes précédentes pour les réutiliser facilement chaque semaine.
            </p>
          </div>
        </div>

        <!-- Feature 4 -->
        <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8 wow fadeInUp" data-wow-delay=".4s">
          <div class="p-8 bg-white rounded-xl shadow-lg h-full transform transition duration-500 hover:scale-105">
            <div class="mb-6 w-16 h-16 mx-auto flex items-center justify-center bg-blue-100 rounded-xl text-blue-600">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
              </svg>
            </div>
            <h3 class="mb-3 text-xl font-bold text-center">Gratuit pour étudiants</h3>
            <p class="text-gray-600 text-center">
              Accès à toutes les fonctionnalités sans frais avec votre email universitaire. Aucune carte bancaire requise.
            </p>
          </div>
        </div>

        <!-- Feature 5 -->
        <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8 wow fadeInUp" data-wow-delay=".5s">
          <div class="p-8 bg-white rounded-xl shadow-lg h-full transform transition duration-500 hover:scale-105">
            <div class="mb-6 w-16 h-16 mx-auto flex items-center justify-center bg-blue-100 rounded-xl text-blue-600">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <h3 class="mb-3 text-xl font-bold text-center">Temps réel</h3>
            <p class="text-gray-600 text-center">
              Les modifications apparaissent instantanément pour tous les membres de la liste, même sur mobile.
            </p>
          </div>
        </div>

        <!-- Feature 6 -->
        <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8 wow fadeInUp" data-wow-delay=".6s">
          <div class="p-8 bg-white rounded-xl shadow-lg h-full transform transition duration-500 hover:scale-105">
            <div class="mb-6 w-16 h-16 mx-auto flex items-center justify-center bg-blue-100 rounded-xl text-blue-600">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
              </svg>
            </div>
            <h3 class="mb-3 text-xl font-bold text-center">Sécurisé</h3>
            <p class="text-gray-600 text-center">
              Vos données sont chiffrées et protégées. Nous ne vendons ni ne partageons vos informations.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Student Verification Section -->
  <section class="py-20 bg-blue-600 text-white">
    <div class="container mx-auto px-4">
      <div class="max-w-4xl mx-auto">
        <div class="flex flex-wrap items-center -mx-4">
          <div class="w-full lg:w-1/2 px-4 mb-12 lg:mb-0">
            <h2 class="mb-6 text-3xl md:text-4xl font-bold">Vérification étudiante</h2>
            <p class="mb-8 text-blue-100 leading-relaxed">
              Pour bénéficier de l'offre gratuite, vérifiez simplement votre statut étudiant avec votre email universitaire.
              Aucun document n'est nécessaire.
            </p>
            <ul class="mb-10 space-y-4">
              <li class="flex items-center">
                <svg class="mr-3 w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>100% gratuit - pas de version premium</span>
              </li>
              <li class="flex items-center">
                <svg class="mr-3 w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Aucune limitation de fonctionnalités</span>
              </li>
              <li class="flex items-center">
                <svg class="mr-3 w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Valable pendant toute votre scolarité</span>
              </li>
            </ul>
            <a href="register.php" class="inline-block py-4 px-8 text-blue-600 font-bold bg-white hover:bg-gray-100 rounded-full transition duration-200 transform hover:scale-105">
              S'inscrire gratuitement
            </a>
          </div>
          <div class="w-full lg:w-1/2 px-4">
            <div class="relative mx-auto max-w-max">
              <div class="relative overflow-hidden rounded-2xl shadow-2xl border-4 border-white">
                <img class="w-full h-auto" src="assets/images/student-verification.png" alt="Vérification étudiante">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="py-20">
    <div class="container mx-auto px-4">
      <div class="max-w-2xl mx-auto mb-16 text-center">
        <span class="text-lg font-bold text-blue-500">TÉMOIGNAGES</span>
        <h2 class="mt-8 mb-10 text-3xl md:text-4xl font-bold font-heading">Ce que disent les étudiants</h2>
      </div>
      <div class="flex flex-wrap -mx-4">
        <!-- Testimonial 1 -->
        <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8 wow fadeInUp" data-wow-delay=".1s">
          <div class="p-8 bg-white rounded-xl shadow-md h-full">
            <div class="mb-4 text-yellow-400">
              <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
              <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
              <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
              <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
              <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
            </div>
            <p class="mb-6 text-gray-600 leading-relaxed">
              "En colocation à 5, Kotaybi nous a sauvé la vie ! Plus besoin de 5 listes différentes ou de messages sans fin pour savoir qui achète quoi."
            </p>
            <div class="flex items-center">
              <img class="w-12 h-12 rounded-full object-cover" src="assets/images/testimonial-1.jpg" alt="Marie D.">
              <div class="ml-4">
                <h4 class="text-lg font-bold">Marie D.</h4>
                <p class="text-gray-500">Étudiante en médecine, Paris</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Testimonial 2 -->
        <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8 wow fadeInUp" data-wow-delay=".2s">
          <div class="p-8 bg-white rounded-xl shadow-md h-full">
            <div class="mb-4 text-yellow-400">
              <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
              <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
              <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
              <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
              <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
            </div>
            <p class="mb-6 text-gray-600 leading-relaxed">
              "La fonctionnalité qui catégorise automatiquement les produits est géniale. Ça m'évite de faire des allers-retours dans le magasin !"
            </p>
            <div class="flex items-center">
              <img class="w-12 h-12 rounded-full object-cover" src="assets/images/testimonial-2.jpg" alt="Thomas L.">
              <div class="ml-4">
                <h4 class="text-lg font-bold">Thomas L.</h4>
                <p class="text-gray-500">Étudiant en informatique, Lyon</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Testimonial 3 -->
        <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8 wow fadeInUp" data-wow-delay=".3s">
          <div class="p-8 bg-white rounded-xl shadow-md h-full">
            <div class="mb-4 text-yellow-400">
              <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
              <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
              <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
              <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
              <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
            </div>
            <p class="mb-6 text-gray-600 leading-relaxed">
              "Kotaybi est super intuitif ! Pouvoir réutiliser nos listes chaque semaine nous fait gagner un temps fou."
            </p>
            <div class="flex items-center">
              <img class="w-12 h-12 rounded-full object-cover" src="assets/images/testimonial-3.jpg" alt="Sophie M.">
              <div class="ml-4">
                <h4 class="text-lg font-bold">Sophie M.</h4>
                <p class="text-gray-500">Étudiante en droit, Bordeaux</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action Section -->
  <section class="py-20 bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
    <div class="container mx-auto px-4 text-center">
      <h2 class="mb-6 text-3xl md:text-4xl font-bold animate-fadeIn">
        Prêt à simplifier vos courses ?
      </h2>
      <p class="mb-8 text-lg text-blue-100 max-w-2xl mx-auto leading-relaxed">
        Rejoignez des milliers d'étudiants qui utilisent Kotaybi pour organiser leurs courses en colocation. C'est gratuit, sécurisé et super simple !
      </p>
      <div class="flex flex-wrap justify-center gap-4">
        <a href="register.php" class="inline-block py-4 px-8 text-blue-600 font-bold bg-white hover:bg-gray-100 rounded-full transition duration-200 transform hover:scale-105 wow fadeInUp" data-wow-delay=".1s">
          S'inscrire maintenant
        </a>
        <a href="contact.php" class="inline-block py-4 px-8 text-white font-bold border-2 border-white hover:bg-blue-700 rounded-full transition duration-200 transform hover:scale-105 wow fadeInUp" data-wow-delay=".2s">
          Nous contacter
        </a>
      </div>
    </div>
  </section>
</main>

<?php include 'includes/footer.php'; ?>