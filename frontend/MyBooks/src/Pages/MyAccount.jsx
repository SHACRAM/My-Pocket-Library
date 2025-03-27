import React from "react";
import { useState, useEffect } from "react";
import axios from "axios";
import { NavLink } from "react-router-dom";



export const MyAccount = () => {
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');

    

    
    const handleUserInformations = async ()=>{
        const response = await axios.get("http://localhost:8888/userInformations",  {withCredentials: true});
        if(response.data.code === 200){
            setName(response.data.userData.name);
            setEmail(response.data.userData.email);
            
            
           
    }

    }

    useEffect(()=>{
        handleUserInformations();
    },[]);





    return(<div>
        <h1>Mon compte</h1>
        <NavLink to='/Accueil'>Accueil</NavLink>
        <div>
            <h2>Mes informations</h2>
            <div>
                <p>Nom :{name} </p> 
                <p>Email : {email} </p> 
                <NavLink to="/ModifyPassword" >Modifier mon mot de passe</NavLink>
                <NavLink to="/ModifyUserInfo">Modifier mes informations</NavLink>
            </div>
             
        </div>
    </div>)



}