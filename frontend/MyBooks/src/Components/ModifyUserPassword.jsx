import React from "react";
import { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";

export const ModifyUserPassword = () => {
    const [newPassword, setNewPassword] = useState('');
    const [message, setMessage] = useState('');
    const navigate = useNavigate();

    const handleSubmit = async (e) => {
        e.preventDefault();

        const response = await axios.put("http://localhost:8888/updatePassword", {newPassword}, {
            headers: { "Content-Type": "application/json" },
            withCredentials: true
        });
        console.log(response);

        if (response.data.code === 200){
            setMessage(response.data.message);
            setTimeout(()=>{
                navigate('/MyAccount');
            }, 1000);
        } else {
            setMessage(response.data.message);
        }
    };


    return (
        <div>
            <form onSubmit={handleSubmit}>
                <label htmlFor="password">Entrer le nouveau mot de passe</label>
                <input type="password" id="password" name="password" required onChange={(e)=> setNewPassword(e.target.value)}/>
                <button type="submit">Enregistrer</button>
            </form>

        </div>
    )
}