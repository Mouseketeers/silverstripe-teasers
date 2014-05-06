
<% if ManagedTeasers %>
<div class="teasers">
	<% control ManagedTeasers %>
	<div class="teaser large-$ColumnWidth columns <% if Last %> end<% end_if %>">
			<% if Title %><h3>$Title</h3><% end_if %>
			<% if Image %>$Image.SetWidth(300)<% end_if %>
			$Content
			<p>
			<% if Link || ExternalLink %>
				<a href="<% if Link %>$Link.URLSegment<% else_if ExternalLink %>$ExternalLink<% end_if %>">
					<% if LinkTitle %>$LinkTitle<% else %>Read more<% end_if %>
				</a>
			<% end_if %>
			</p>
	</div>
	<% end_control %>
</div>
<% end_if %>