import React from "react";
import axios from "axios";
import { useState, useEffect } from "react";
import { ModifyUserForm } from "../Components/ModifyUserForm";

export const ModifyUserInfo = () => {
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');
    const [message, setMessage] = useState('');
    

    const handleUserInformations = async ()=>{
        const response = await axios.get("http://localhost:8888/userInformations",  {withCredentials: true});
        if(response.data.code === 200){
            setName(response.data.userData.name);
            setEmail(response.data.userData.email);
    } else {
        setMessage(response.data.message);

    }
}

    useEffect(()=>{
        handleUserInformations();
    },[]); 




    return (
        <div>
            <ModifyUserForm name={name} email={email}/>
        </div>
    )
}