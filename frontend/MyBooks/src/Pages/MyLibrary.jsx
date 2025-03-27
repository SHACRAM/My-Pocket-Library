import React from "react";
import { useState, useEffect } from "react";
import axios, { all } from "axios";
import { NavLink } from "react-router-dom";


export const MyLibrary = () => {
    const [message, setMessage] = useState('');
    const [countBooks, setCountBooks] = useState();
    const [allBooks, setAllBooks] = useState([]);
    const [searchTerm, setSearchTerm] = useState('');
    const [filteredBooks, setFilteredBooks] = useState([]);

    const handleAllBooks = async ()=>{
        try{
            const response = await axios.get("http://localhost:8888/getAllBooks", {withCredentials: true});
            if(response.data.code === 200){
                const books = response.data.books
                setAllBooks(books.sort((a,b)=> a.name.localeCompare(b.name)));
            }

        }catch (error){
            console.error("Erreur lors de la récupération des livres", error);
            setMessage("Erreur lors de la récupération des livres");
        }
    }

    const handleCountBooks = async ()=>{
        try{
            const response = await axios.get("http://localhost:8888/countAllBooks", {withCredentials: true});
            if(response.data.code === 200){
                setCountBooks(response.data.total);

            }


        }catch(error)
        {
            console.error("Erreur lors de la récupération du nombre de livres", error);
            setMessage("Erreur lors de la récupération du nombre de livres");
        }
    }

    const handleSearch = (searchTerm) => {
        const results = allBooks.filter((book) => 
            book.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
            book.author.toLowerCase().includes(searchTerm.toLowerCase())
        );
        setFilteredBooks(results);
    };

    const handleDelete = async (id) => {
        try{
            
            console.log(id);
            const response = await axios.post("http://localhost:8888/deleteBook", {id}, {withCredentials: true});
            if(response.data.code === 200){
                setMessage(response.data.message);
                handleAllBooks();
                handleCountBooks();
                setTimeout(()=>{
                    setMessage('');
                },1000);
            }

        }catch(error){
            console.error("Erreur lors de la suppression du livre", error);
            setMessage("Erreur lors de la suppression du livre");
        }
    };
    


    useEffect(()=>{
        handleCountBooks();
        handleAllBooks();
        handleSearch(searchTerm);
    },[searchTerm]);


    return(
        <div>
            <h1>Ma bibliotheque</h1>
            <NavLink to='/Accueil'>Accueil</NavLink>
            <p>Nombre de livre dans ma bibliotheque : {countBooks}</p>
            <h2>Mes livres</h2>
            <label htmlFor="search">Rechercher un livre</label>
            <input type="search" id="search" name="search" required placeholder="exemple : naruto" onChange={(e)=> setSearchTerm(e.target.value)}/>
            {filteredBooks.length > 0 ? 
            <div>
                {filteredBooks.map((book, index) => {
                    return(
                        <div key={index}>
                            <p>{book.name}</p>
                            <p>{book.author}</p>
                            <img src={book.image} alt={book.name} />
                            <button onClick={()=>handleDelete(book.id)}>Retirer de la bibliotheque</button>
                        </div>
                    )
                }
                )}
            </div>
            : allBooks.map((book, index) => {
                return(
                    <div key={index}>
                    <p>{book.name}</p>
                    <p>{book.author}</p>
                    <img src={book.image} alt={book.name} />
                    <button onClick={()=>handleDelete(book.id)}>Retirer de la bibliotheque</button>
                </div>
                ) 
            }
            )

            }
            

        </div>
    )
}