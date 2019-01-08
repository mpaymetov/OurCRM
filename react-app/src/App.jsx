import React, {Component} from 'react';
import Start from './component/start.jsx';
import Form from './component/form.jsx';
import TopMenu from './component/topMenu.jsx';
import Funnel from './component/main/funnelWrap.jsx';
import NotFound from './component/notfound.jsx';
import Nav from './component/nav.jsx';
import EventWarp from './component/event/eventWarp.jsx';

import {BrowserRouter as Router, Route, Switch} from 'react-router-dom';


class App extends Component {


    render() {
        return (
            <div className="App">
                <header className="App-header">
                    <Router>
                        <div>
                            <Nav/>
                            <Switch>
                                <Route exact path="/" component={Form}/>
                                <Route path="/products" component={Start}/>
                                <Route path="/funnels" component={Funnel}/>
                                <Route path="/events" component={EventWarp}/>
                                <Route component={NotFound}/>
                            </Switch>
                        </div>
                    </Router>
                </header>
            </div>
        );
    }
}

export default App;

