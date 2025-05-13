    <?php

    use App\Http\Controllers\Api\UserController;
    use App\Http\Controllers\Api\GymProductController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Api\MembershipTypeController;
    use App\Http\Controllers\Api\MembershipController;
    use App\Http\Controllers\Api\SupplementController;
    use App\Http\Controllers\Api\ClothingController;
    use App\Http\Controllers\Api\AccessoryController;
    use App\Http\Controllers\Auth\LoginController;
    use App\Http\Controllers\Auth\RegisterController;
    use App\Http\Controllers\Auth\LogoutController;
    use App\Http\Controllers\Api\ReviewController;
    use App\Http\Controllers\Api\AdminController;
   
    Route::post('/login', LoginController::class); // Added login route
    Route::post('/register', RegisterController::class); // Added registration route
    Route::post('/logout', [LogoutController::class, 'logout']);
    Route::post('/lookForProduct', [UserController::class, 'lookForProduct']);


    Route::prefix('admin')->group(function () {
    // User Management
        Route::get('/users', [AdminController::class, 'listUsers']);
        Route::post('/users', [AdminController::class, 'addUser']);
        Route::put('/users/{id}', [AdminController::class, 'updateUser']);
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
        
        // Product Management
        Route::post('/products', [AdminController::class, 'createProduct']);
        Route::put('/products/{id}', [AdminController::class, 'updateProduct']);
        Route::delete('/products/{id}', [AdminController::class, 'deleteProduct']);
        // Route::get('/products/stats', [AdminController::class, 'productStatistics']);
        // Route::get('/users/count', [AdminController::class, 'countUsers']);
        Route::get('/products/all', [AdminController::class, 'listAllProducts']);
        Route::put('/purchases/{purchaseId}', [AdminController::class, 'modifyPurchase']);
        Route::get('/purchases', [AdminController::class, 'getAllPurchases']);

        Route::get('/reviews', [AdminController::class, 'getAllReviews']);
         Route::put('/reviews/{reviewId}', [AdminController::class, 'updateReview']);
        Route::delete('/reviews/{reviewId}', [AdminController::class, 'deleteReview']);

    });

    Route::apiResource('user-actions', UserController::class); // custom name to avoid conflict

 
    Route::apiResource('GymProduct', GymProductController::class);
    Route::post('/purchaseProduct/{productId}', [UserController::class, 'purchaseProduct']);
   
    Route::apiResource('membership-types', MembershipTypeController::class);
    Route::apiResource('memberships', MembershipController::class); // Corrected route name and controller

    Route::apiResource('supplements', SupplementController::class); // Added route for supplements

    Route::apiResource('clothing', ClothingController::class); // Added route for clothing

    Route::apiResource('accessories', AccessoryController::class); // Added route for accessories

    Route::apiResource('reviews', ReviewController::class); // Added route for reviews    




    ?>
