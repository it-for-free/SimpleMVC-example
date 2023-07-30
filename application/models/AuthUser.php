<?php
namespace application\models;

use ItForFree\SimpleMVC\User;
/**
 * Класс для проверки авторизационных данных пользователя
 */
class AuthUser extends User
{        
    
    /**
     * Проверка логина и пароля пользователя.
     */
    protected function checkAuthData($login, $pass): bool {
	$result = false;
	$User = new UserModel();
	$siteAuthData = $User->getAuthData($login);	
        if (isset($siteAuthData['pass'])) {
	    $pass .= $siteAuthData['salt'];
	    $passForCheck = password_verify($pass, $siteAuthData['pass']);
	    if ($passForCheck) {
		$result = true;
	    }
	}	
        return $result;
    }

    /**
     * Получить роль по имени пользователя
     */
    protected function getRoleByUserName($login): string {
	$User = new UserModel();
	$siteAuthData = $User->getRole($login);
	if (isset($siteAuthData['role'])) {
	    return $siteAuthData['role'];
        }
    }

}
