import React from "react";
import axios from "axios";
import { useState } from "react";
import { useNavigate } from "react-router-dom";

export const ModifyUserForm = ({name, email}) => {
    const [newName, setNewName] = useState(name);
    const [newEmail, setNewEmail] = useState(email);
    const [message, setMessage] = useState('');
    const navigate = useNavigate();

    const handleSubmit = async (e) => {
        e.preventDefault();
        const payload = {newName, newEmail};

        try{

            const response = await axios.put("http://localhost:8888/updateInfo", payload, { 
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




        }catch(error){
            console.error("Erreur lors de la modification des informations :", error);
        }





    }




    return (
        <div>
            <form onSubmit={handleSubmit}>
                <label htmlFor="name">Votre nom</label>
                <input type="text" id="name" name="name" required onChange={(e)=>setNewName(e.target.value)} value={newName}/>
                <label htmlFor="email">Votre email</label>
                <input type="mail" id="email" name="email" required onChange={(e)=>setNewEmail(e.target.value)} value={newEmail}/>
                <button type="submit">Modifier mes informations</button>
            </form>
            {message && <p>{message}</p>}

        </div>
    )
};