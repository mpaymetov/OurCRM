import React, {Component} from 'react';
import TopWrap from "./component/nav/topWrap.jsx";

class App extends Component {

    render() {
        return (
            <div className="wrap">
                <div className="container">
                    <TopWrap/>
                </div>
            </div>
        );
    }
}

export default App;

