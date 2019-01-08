import React, {Component} from 'react';


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