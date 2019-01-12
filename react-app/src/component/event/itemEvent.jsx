import React, {Component} from 'react';
import {BrowserRouter as Router, Route, Switch, Link, Redirect} from 'react-router-dom';
import EventView from "./EventView.jsx";


class ItemEvent extends Component {
    constructor(props) {
        super(props);
        this.state =
            {hits: this.props.items};
    }

    render() {
        console.log('in component', this.props);
        if (this.props.hits !== '') {
            console.log('not null', this.props.items);
            return (
                <div>
                    {this.props.items.map((hits) =>
                        <div className="panel-body post panel">
                            <div className="col-md-6">
                                <p className="post_number">номер события:{hits.id_event || ''}</p>
                                <h5>{hits.message || ''}</h5>
                                <h6>{hits.id_user}</h6>
                            </div>
                            <Router>
                                <div>
                                    <nav>
                                        <Link to={"eventsView"+hits.id_event}> подробнее </Link>
                                    </nav>
                                    <Switch>
                                        <Route path="/eventsView:" component={EventView}/>
                                    </Switch>
                                </div>
                            </Router>
                        </div>
                    )}
                </div>
            )
        } else {
            return (<p>do not render</p>);
        }

    }
}

export default ItemEvent;