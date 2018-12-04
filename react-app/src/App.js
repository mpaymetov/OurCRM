import React from 'react';
import './App.css';
import Start from './component/start';
import Form from './component/form';

class App extends React.Component {

    gettingInfo = async (event) => {

        event.preventDefault();
        const api_url = await fetch("http://localhost/OurCRM/api/index/index.php");
        const data = await api_url.json();
        console.log(data);
    }


    render() {
        return (
            <div className="App">
                <header className="App-header">
                    <div>
                        <Start/>
                        <Form info={this.gettingInfo}/>
                    </div>
                </header>
            </div>
        );
    }
}

export default App;
