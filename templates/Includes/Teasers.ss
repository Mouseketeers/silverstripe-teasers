<% if Teasers %>
	<% control Teasers %>
	<li class="teaser">
			<% if Image %>$Image<% end_if %>
			<h2>$Title</h2>
			$Content
		<% if LinkTitle %><a href="$Link.URLSegment" class="button radius">$LinkTitle</a><% end_if %>
	</li>
	<% end_control %>
<% end_if %>