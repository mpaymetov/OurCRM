import React, {Component} from 'react';
import {Link, BrowserRouter} from 'react-router-dom';


class ItemPost extends Component {
    constructor(props) {
        super(props);
        this.state =
            {hits: this.props.column};
    }

    render() {
        console.log(this.state);
        if (this.props.hits !== '') {
            return (
                <div className="container back">
                    {this.props.column.map((hits) => //todo попробовать вынести в функцию
                        <div className="panel-body post panel">
                            <div className="col-md-6">
                                <p className="post_number">номер события:{hits.id || ''}</p>
                                <h5>{hits.message || ''}</h5>
                                <h6>{hits.id_user}</h6>
                            </div>
                            <nav>
                                <Link to={"/eventsView/" + hits.id_event}> подробнее </Link>
                            </nav>
                        </div>
                    )}
                </div>
            )
        }
        return <p>пока нет событий</p>

    }
}

export default ItemPost;
