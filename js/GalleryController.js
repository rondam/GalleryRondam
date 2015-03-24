var galleryApp = angular.module('galleryApp', []);

galleryApp.controller('GalleryController', function ($scope, $http) {
	$scope.images = [];
	$http.get('backend/index.php/image_gallery_controller').success(function(data) {
		for (var i in data.images)
		{
			// push = añadir a array
			$scope.images.push('backend/index.php/image_gallery_controller/gallery/' + data.images[i].id);
		}
		$scope.images = data.images;
	});

    // NAV IMAGES
    $scope.showImage = false;
	$scope.imageOnClick = function(image){
        $scope.showImage = true;

        $scope.currentImage = image;

        $scope.comments =[];

        $http.get('backend/index.php/comment_controller/index/' + $scope.currentImage.id).success(function(comments){
            $scope.comments = comments;
        });
    };

    $scope.viewPrevImage = function(){
        var index = $scope.images.indexOf($scope.currentImage);
        index--;
        if (index < 0)
        {
            index = $scope.images.length - 1;
        }
        $scope.imageOnClick($scope.images[index]);
    };

    $scope.viewNextImage = function(){
        var index = $scope.images.indexOf($scope.currentImage);
        index++;
        if (index === $scope.images.length)
        {
            index = 0;
        }
        $scope.imageOnClick($scope.images[index]);
    };

    $scope.closeImage = function (){
        $scope.showImage = false;
        /*vaciar los comentarios */
        $scope.comments = null;
    };


    // MAIN PAGE

    $scope.showMainPage = true;

    $scope.showMainPageOnClick = function(){
        $scope.showMainPage = true;
    }

    // GALLERY

    $scope.showGalleryOnClick = function(){
        $scope.showMainPage = false;
    }



    //SHOW COMMENTS

    $scope.submitComment = function() {
        var author = document.getElementById('comment_author').value;
        var text = document.getElementById('comment_text').value;
        if (author && text)
        {
            var params = {name: author, comment: text};
            //https://stackoverflow.com/questions/19910021/javascript-object-json-to-url-string-format
            var str = Object.keys(params).map(function(key){
                return encodeURIComponent(key) + '=' + encodeURIComponent(params[key]);
            }).join('&');
            $http({
                url: 'backend/index.php/comment_controller/add_comment/' + $scope.currentImage.id,
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                data: str
            }).then(function()
            {
                $http.get('backend/index.php/comment_controller/index/' + $scope.currentImage.id).success(function(comments){
                    $scope.comments = comments;
                    document.getElementById('comment_author').value = '';
                    document.getElementById('comment_text').value = '';
                });
            });
        }
    }


});

