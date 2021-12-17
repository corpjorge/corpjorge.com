import React from 'react';
import Link from "next/link";

export default class Header extends React.Component {

    componentDidMount() {
        document.getElementById("__next").setAttribute("class", "cover-container d-flex w-100 h-100 p-3 mx-auto flex-column");
    }

    render() {
        return (

                <header className="padd">
                    <div>
                        <h3 className="float-md-start mb-0">CorpJorge</h3>
                        <nav className="nav nav-masthead justify-content-center float-md-end">
                            <Link href="/" >
                                <a className="nav-link active" aria-current="page">Hello</a>
                            </Link>
                            <Link href="/dev" >
                                <a className="nav-link" >DeV</a>
                            </Link>
                            <Link href="/contact" >
                                <a className="nav-link" >Contact</a>
                            </Link>
                        </nav>
                    </div>
                </header>
        )
    }
}