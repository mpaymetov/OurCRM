import React, {Component} from 'react';
import Nav from './Nav.jsx';
import URLRouter from './router.jsx';
import {BrowserRouter as Router, Route, Switch} from 'react-router-dom';


class TopWrap extends Component {

    render() {
        return (
            <div>
                <Router>
                    <div className="top_wrap">
                        <Nav/>
                        <URLRouter/>
                    </div>
                </Router>
            </div>
        )
    }
}

export default TopWrap