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

   
    Route::post('/login', LoginController::class); // Added login route
    Route::post('/register', RegisterController::class); // Added registration route
    Route::post('/logout', [LogoutController::class, 'logout']);
    Route::post('/purchaseProduct/{membershipId}', [UserController::class, 'purchaseProduct']);

    Route::apiResource('users', UserController::class);
 
    Route::apiResource('GymProduct', GymProductController::class);
    Route::post('/purchaseProduct/{productId}', [UserController::class, 'purchaseProduct']);
   
    Route::apiResource('membership-types', MembershipTypeController::class);
    Route::apiResource('memberships', MembershipController::class); // Corrected route name and controller

    Route::apiResource('supplements', SupplementController::class); // Added route for supplements

    Route::apiResource('clothing', ClothingController::class); // Added route for clothing

    Route::apiResource('accessories', AccessoryController::class); // Added route for accessories

    Route::middleware('auth:sanctum')->apiResource('reviews', ReviewController::class);





    ?>
