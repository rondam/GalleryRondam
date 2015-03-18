var galleryApp = angular.module('galleryApp', []);

galleryApp.controller('GalleryController', function ($scope, $http) {
	$scope.images = [];
	$http.get('backend/index.php/image_gallery_controller').success(function(data) {
		console.log(data);
		for (var i in data.images)
		{
			// push = añadir a array
			$scope.images.push('backend/index.php/image_gallery_controller/gallery/' + data.images[i].id);
		}
		$scope.images = data.images;
		
	});
	
	// La vista solo ve las cosas que estan en $scope; es como el $context en
	// CodeIgniter.
});

