import React, {Component} from 'react';


class ItemPost extends Component {
    constructor(props) {
        super(props);
        const posts = this.props;

    }

    render() {
        console.log('in component', this.props.posts);
        if (this.props.posts !== null) {
            console.log('not null', this.props.posts.hits);
            return (
                <div>
                    <div>
                        {this.props.posts.hits.map((item) =>
                            <div className="panel-body post panel">
                                <div>{item.state || ''}</div>
                            </div>
                        )}
                    </div>
                </div>
            )

        } else {
            return (<p>do not render</p>);
        }

    }
}

export default ItemPost;