import React from 'react';

export default class Footer extends React.Component {

    componentDidMount() {
        document.getElementById("__next").setAttribute("class", "cover-container d-flex w-100 h-100 p-3 mx-auto flex-column");
    }

    render() {
        return (
            <footer className="mt-auto text-white-50">
                <p>Created By <a href="https://superfluo.co/" className="text-white">SuperFluo.co</a></p>
            </footer>
        )
    }
}

