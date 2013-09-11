<% if Teasers %>
	<% control Teasers %>
	<li class="teaser">
		<% if Link %><a href="$Link.URLSegment"><% end_if %>
			<% if Image %>$Image<% end_if %>
			<h4>$Title</h4>
			$Content
		<% if Link %></a><% end_if %>
	</li>
	<% end_control %>
<% end_if %>