<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 19.10.2021
 * Time: 11:58
*/

namespace src\test_models;

/**
 * @Table (name=user_profile);
 */
class UserProfile{
    /**
     * User profile id
     * @Column (name=ID, type=int, auto_generated=true, nullable=false);
     * @var int
     */
    public int $id;

    /**
     * User profile email address
     * @Column (name=EMAIL, type=string, nullable=false);
     * @var string
     */
    public string $userEmail;


    /**
     * User status
     * @Column (name=STATUS, type=string, nullable=true);
     * @var string
     */
    public string $userStatus;
}