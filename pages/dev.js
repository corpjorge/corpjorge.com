import React from "react";
import Header from "../components/header";
import Footer from "../components/footer";

export default class Dev extends React.Component {

    componentDidMount() {
        document.getElementById("__next").setAttribute("class", "cover-container d-flex w-100 h-100 p-3 mx-auto flex-column")
    }

    render() {
        return (
            <div>
                <Header/>
                <main className="px-3">
                    <h1>Estamos trabajando en ello</h1>
                </main>
                <Footer/>
            </div>
        )
    }
}