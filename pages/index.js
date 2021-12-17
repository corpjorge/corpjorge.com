import React from 'react';
import Link from "next/link";
import Header from "../components/header";
import Footer from "../components/footer";

export default class Home extends React.Component {

    componentDidMount() {
        document.getElementById("__next").setAttribute("class", "cover-container d-flex w-100 h-100 p-3 mx-auto flex-column");
    }

    render() {
        return (
            <div>
                <Header/>
                <main className="px-3">
                    <h1>Paga Of CorpJorge.</h1>
                    <p className="lead">Aquí pronto algo interesante.</p>
                    <p className="lead">
                        <a href="#" className="btn btn-lg btn-secondary fw-bold border-white bg-white">Botón de adorno</a>
                    </p>
                </main>
                <Footer/>
            </div>
        )
    }
}

